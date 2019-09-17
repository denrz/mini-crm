<template>
    <div>
        <file-upload />
        <form @submit.prevent="submitForm">
            <div class="card-body">
                <input-field name="name" label="Name" placeholder="Company Name"
                             :errors="errors" @update:field="form.name = $event" />
                <input-field name="email" label="Email" placeholder="Company Email"
                             :errors="errors" @update:field="form.email = $event" />
                <input-field name="website" label="Website" placeholder="Company Website"
                             :errors="errors" @update:field="form.website = $event" />
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button @click.prevent="onCancel" class="btn btn-primary">Cancel</button>
                <button class="btn btn-primary">Add</button>
            </div>
        </form>
    </div>
</template>

<script>
    import InputField from '../components/InputField';
    import FileUpload from '../components/FileUpload';

    export default {
        name: "companies-create",

        components: {
            InputField, FileUpload
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

        methods: {
            submitForm: function () {
                axios.post('/api/companies', this.form)
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