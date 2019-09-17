<template>
    <div>
        <h3 class="ml-4 mt-2">Companies</h3>
        <companies-list :is_admin="is_admin" endpoint="/api/companies" />
        <router-link v-if="is_admin" to="/companies/create" class="btn btn-primary ml-2"><i class="fas fa-plus"></i> Add New</router-link>
    </div>
</template>

<script>
    import CompaniesList from '../components/CompaniesList';
    export default {
        name: "companies-index",

        components: {
            CompaniesList
        },

        props: [
            'is_admin'
        ]
    }
</script>

<style scoped>

</style>