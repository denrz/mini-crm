<template>
    <div>
        <div v-if="loading">Loading...</div>
        <div v-else>
            <button type="button" @click="$router.push('/companies')" class="btn btn-default btn-sm"><i class="fas fa-arrow-left"></i> Back</button>

            <div class="ml-4 mt-4">
                <h2 class="lead"><b>{{ company.name }}</b></h2>
                <ul class="ml-4 mb-4 fa-ul text-muted">
                    <li><span class="fa-li"><i class="fas fa-lg fa-building"></i></span>{{ company.email }}</li>
                    <li><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span>{{ company.website }}</li>
                </ul>

                <div v-if="is_admin">
                    <router-link :to="'/companies/' + company.company_id + '/edit'">
                        <button class="btn btn-primary">Edit</button>
                    </router-link>
                    <button class="btn btn-danger" @click="destroy">Delete</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import EmployeesList from '../components/EmployeesList';

    export default {
        name: "companies-show",

        props: [
            'is_admin'
        ],

        components: {
            EmployeesList
        },

        mounted() {
            axios.get('/api/companies/' + this.$route.params.id)
                .then(response => {
                    this.company = response.data.data;
                    this.loading = false;
                })
                .catch(error => {
                    this.loading = false;

                    if(error.response.status === 404) {
                        this.$router.push('/companies');
                    }
                });
        },

        data: function() {
            return {
                loading: true,
                company: null
            }
        },

        methods: {
            destroy: function () {
                axios.delete('/api/companies/' + this.$route.params.id)
                    .then(response => {
                        this.$router.push('/companies');
                    })
                    .catch(errors => {
                        alert('Internal Error. Unable to delete company');
                    });
            }
        }
    }
</script>

<style scoped>

</style>