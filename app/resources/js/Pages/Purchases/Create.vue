<script setup>
import { getToday } from '@/common'
import { useForm } from '@inertiajs/vue3';
import { onMounted } from 'vue'

onMounted(() => {
    form.date = getToday()
})

const form = useForm({
    date: null
})
</script>
<template>
    日付<br>
    <input type="date" name="date" v-model="form.date">
</template>
