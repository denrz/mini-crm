<template>
    <div v-if="loading">Loading...</div>
    <div v-else>
        <div v-if="employees.length === 0">
            <p>No employees</p>
        </div>

        <table class="table table-hover">
            <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Company</th>
                <th>Email</th>
                <th>Phone</th>
                <th v-if="is_admin"></th>
            </tr>
            </thead>
            <tbody>
            <router-link v-for="(employee, index) in employees" :key="index" :to="'/employees/' + employee.data.employee_id" tag="tr" class="cursor-pointer">
                <td>{{ employee.data.first_name }}</td>
                <td>{{ employee.data.last_name }}</td>
                <td>{{ employee.data.company }}</td>
                <td>{{ employee.data.email }}</td>
                <td>{{ employee.data.phone }}</td>
                <td v-if="is_admin" class="text-right">
                    <button @click.prevent="edit(employee.data.employee_id)" class="btn btn-primary btn-sm">
                        <i class="fas fa-pencil-alt">
                        </i>
                        Edit
                    </button>
                    <button @click.prevent="destroy(employee.data.employee_id)" class="btn btn-danger btn-sm">
                        <i class="fas fa-trash">
                        </i>
                        Delete
                    </button>
                </td>
            </router-link>
            </tbody>
        </table>

    </div>
</template>

<script>
    export default {
        name: "employees-list",

        props: [
            'endpoint', 'is_admin'
        ],

        mounted() {
            axios.get(this.endpoint)
                .then(response => {
                    this.employees = response.data;
                    this.loading = false;
                })
                .catch(error => {
                    this.loading = false;
                    alert('Unable to fetch employees');
                });
        },

        data: function () {
            return {
                loading: true,
                employees: null
            }
        },

        methods: {
            destroy: function (employee_id) {
                axios.delete('/api/employees/' + employee_id)
                    .then(response => {
                        this.employees= this.employees.filter(employee=>employee.data.employee_id!==employee_id)
                    })
                    .catch(errors => {
                        alert('Internal Error. Unable to delete employee');
                    });
            },
            edit: function (employee_id) {
                this.$router.push('/employees/' + employee_id + '/edit');
            }
        }
    }
</script>

<style scoped>
    .cursor-pointer {
        cursor: pointer;
    }
</style>