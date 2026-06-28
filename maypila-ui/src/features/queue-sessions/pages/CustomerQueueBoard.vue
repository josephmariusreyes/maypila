<script setup lang="ts">
import { useRoute } from 'vue-router'

const route = useRoute()

const queueSessionId = Number(route.params.queueSessionId)
</script>
<template>
    Customer Queue Board
    ( {{ queueSessionId }} )
    ( This will display all the customers in pending, inprogress, done )
    ( Usage of this is we will display this in a public screen )
</template>
