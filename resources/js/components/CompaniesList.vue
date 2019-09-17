<template>
    <div v-if="loading">Loading...</div>
    <div v-else>
        <div v-if="companies.length === 0">
            <p>No companies</p>
        </div>

        <table class="table table-hover">
            <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Website</th>
                <th v-if="is_admin"></th>
            </tr>
            </thead>
            <tbody>
            <router-link v-for="(company, index) in companies" :key="index" :to="'/companies/' + company.data.company_id" tag="tr" class="cursor-pointer">
                <td>{{ company.data.name }}</td>
                <td>{{ company.data.email }}</td>
                <td>{{ company.data.website }}</td>
                <td v-if="is_admin" class="text-right">
                    <button @click.prevent="edit(company.data.company_id)" class="btn btn-primary btn-sm">
                        <i class="fas fa-pencil-alt">
                        </i>
                        Edit
                    </button>
                    <button @click.prevent="destroy(company.data.company_id)" class="btn btn-danger btn-sm">
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
        name: "companies-list",

        props: [
            'endpoint', 'is_admin'
        ],

        mounted() {
            axios.get(this.endpoint)
                .then(response => {
                    this.companies = response.data;
                    this.loading = false;
                })
                .catch(error => {
                    this.loading = false;
                    alert('Unable to fetch companies');
                });
        },

        data: function () {
            return {
                loading: true,
                companies: null
            }
        },

        methods: {
            destroy: function (company_id) {
                axios.delete('/api/companies/' + company_id)
                    .then(response => {
                        this.companies= this.companies.filter(company=>company.data.company_id !== company_id)
                    })
                    .catch(errors => {
                        alert('Internal Error. Unable to delete company');
                    });
            },
            edit: function (company_id) {
                this.$router.push('/companies/' + company_id + '/edit');
            }
        }
    }
</script>

<style scoped>
    .cursor-pointer {
        cursor: pointer;
    }
</style>