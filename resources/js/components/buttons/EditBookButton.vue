<template>
    <button class="btn btn-warning btn-sm mr-10" @click="editBook">Edit</button>
</template>

<script>
import { EventBus } from '../../eventBus'
export default {
    name: "EditBookButton",
    props: {
        origin: {
            type: Object,
            default() {
                return {}
            }
        }
    },
    methods: {
        editBook() {
            EventBus.$emit('onShowModal', {type: 'edit', data: {...this.origin}})
        }
    }
}
</script>

<style scoped>
.mr-10 {
    margin-right: 10px;
}
</style>
