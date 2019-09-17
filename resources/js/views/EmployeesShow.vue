<template>
    <div>
        <div v-if="loading">Loading...</div>
        <div v-else>
            <button type="button" @click="$router.push('/employees')" class="btn btn-default btn-sm"><i class="fas fa-arrow-left"></i> Back</button>

            <div class="ml-4 mt-4">
                <h2 class="lead"><b>{{ employee.first_name + ' ' + employee.last_name}}</b></h2>
                <ul class="ml-4 mb-4 fa-ul text-muted">
                    <li><span class="fa-li"><i class="fas fa-lg fa-building"></i></span>{{ employee.company }}</li>
                    <li><span class="fa-li"><i class="fas fa-lg fa-envelope"></i></span>{{ employee.email }}</li>
                    <li><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span>{{ employee.phone }}</li>
                </ul>

                <div v-if="is_admin">
                    <router-link :to="'/employees/' + employee.employee_id + '/edit'">
                        <button class="btn btn-primary">Edit</button>
                    </router-link>
                    <button class="btn btn-danger" @click="destroy">Delete</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "employees-show",

        props: [
            'is_admin'
        ],

        mounted() {
            axios.get('/api/employees/' + this.$route.params.id)
                .then(response => {
                    console.log(response.data.data);
                    this.employee = response.data.data;
                    this.loading = false;
                })
                .catch(error => {
                    this.loading = false;

                    if(error.response.status === 404) {
                        this.$router.push('/employees');
                    }
                });
        },

        data: function() {
            return {
                loading: true,
                employee: null
            }
        },

        methods: {
            destroy: function () {
                axios.delete('/api/employees/' + this.$route.params.id)
                    .then(response => {
                        this.$router.push('/employees');
                    })
                    .catch(errors => {
                        alert('Internal Error. Unable to delete employee');
                    });
            }
        }
    }
</script>

<style scoped>

</style>