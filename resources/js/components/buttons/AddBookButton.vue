<template>
    <button class="btn btn-primary btn-sm" @click="addBook">Tambah</button>
</template>

<script>
import { EventBus } from '../../eventBus'
export default {
    name: "AddBookButton",
    methods: {
        addBook() {
            EventBus.$emit('onShowModal', {type: 'add', data: {judul: '', stok: 0}})
        }
    }
}
</script>

<style scoped>

</style>
