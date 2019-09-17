<template>
    <div>
        <form @submit.prevent="submitForm">
            <div class="card-body">
                <input-field name="name" label="Name" placeholder="Company Name"
                             :errors="errors" @update:field="form.name = $event" :data="form.name" />
                <input-field name="email" label="Email" placeholder="Company Email"
                             :errors="errors" @update:field="form.email = $event" :data="form.email" />
                <input-field name="website" label="Website" placeholder="Company Website"
                             :errors="errors" @update:field="form.website = $event" :data="form.website" />
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button @click.prevent="onCancel" class="btn btn-primary">Cancel</button>
                <button class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</template>

<script>
    import InputField from '../components/InputField';

    export default {
        name: "companies-edit",

        components: {
            InputField
        },

        data: function () {
            return {
                form: {
                    'name': '',
                    'email': '',
                    'website': ''
                },

                errors: null
            }
        },

        mounted() {
            axios.get('/api/companies/' + this.$route.params.id)
                .then(response => {
                    this.form = response.data.data;
                    this.loading = false;
                })
                .catch(error => {
                    this.loading = false;

                    if(error.response.status === 404) {
                        this.$router.push('/companies');
                    }
                });
        },

        methods: {
            submitForm: function () {
                axios.patch('/api/companies/' + this.$route.params.id, this.form)
                    .then(response => {
                        this.$router.push(response.data.links.self);
                    })
                    .catch(errors => {
                        this.errors = errors.response.data.errors;
                    });
            },

            onCancel: function () {
                this.$router.back();
            }
        }
    }
</script>

<style scoped>

</style>