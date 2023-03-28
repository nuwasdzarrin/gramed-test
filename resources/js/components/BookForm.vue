<template xmlns="http://www.w3.org/1999/html">
    <div class="modal fade" id="bookFormModal" tabindex="-1" aria-labelledby="bookFormModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bookFormModalLabel">
                        {{ type === 'add' ? 'Tambah Buku' : `Edit Buku ${origin.judul}` }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form @submit.prevent="onSave" @keydown="form.onKeydown($event)" id="bookInputForm">
                    <div class="modal-body">
                        <AlertError :form="form" />
                        <AlertSuccess :form="form" message="Your changes have been saved!" />
                        <div class="mb-3">
                            <label class="form-label">Judul Buku<span class="text-danger">*</span></label>
                            <input v-model="form.judul" type="text" name="judul" class="form-control">
                            <HasError :form="form" field="judul" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Stok<span class="text-danger">*</span></label>
                            <input v-model="form.stok" type="number" name="stok" class="form-control">
                            <HasError :form="form" field="stok" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Gambar<span class="text-danger">*</span></label>
                            <input type="file" name="gambar" class="form-control" accept="image/jpeg,image/png"
                                   @change="handleFile">
                            <HasError :form="form" field="gambar" />
                        </div>
                        <div v-if="form.progress">Progress: {{ form.progress.percentage }}%</div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <Button :form="form" class="btn btn-primary">Simpan</Button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import Form from 'vform'
import {AlertError, AlertSuccess, Button, HasError} from 'vform/src/components/bootstrap5'
import {EventBus} from '../eventBus'

export default {
    name: "BookForm",
    components: {
        Button, HasError, AlertError, AlertSuccess
    },
    data: () => ({
        type: 'add',
        origin: null,
        form: new Form({
            judul: '',
            stok: '',
            gambar: null
        })
    }),
    methods: {
        handleFile (event) {
            this.form.gambar = event.target.files[0]
        },
        async onSave () {
            const response = await this.form.post(this.type === 'edit' ? `buku/${this.origin.id}` : 'buku')
            if (response.data.action) {
                window.location.reload()
            }
        }
    },
    created () {
        EventBus.$on('onShowModal', (val) => {
            this.type = val.type
            this.origin = val.data
            if (val.type === 'edit') {
                this.form.judul = val.data.judul
                this.form.stok = val.data.stok
                this.form.gambar = val.data.gambar
                this.form._method = "PUT"
            }
            $("#bookFormModal").modal('show')
        })
    }
}
</script>

<style scoped>

</style>
