<template>
    <div>
        <h3 class="ml-4 mt-2">Employees</h3>
        <employees-list :is_admin="is_admin" endpoint="/api/employees" />
        <router-link v-if="is_admin" to="/employees/create" class="btn btn-primary ml-2"><i class="fas fa-plus"></i> Add New</router-link>
    </div>
</template>

<script>
    import EmployeesList from '../components/EmployeesList';
    export default {
        name: "employees-index",

        components: {
            EmployeesList
        },

        props: [
            'is_admin'
        ]
    }
</script>

<style scoped>

</style>