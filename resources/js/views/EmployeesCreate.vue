<template>
    <div>
        <form @submit.prevent="submitForm">
            <div class="card-body">
                <input-field name="first_name" label="First Name" placeholder="Employee First Name"
                             :errors="errors" @update:field="form.first_name = $event" />
                <input-field name="last_name" label="Last Name" placeholder="Employee Last Name"
                             :errors="errors" @update:field="form.last_name = $event" />
                <select-field name="company_id" label="Company" placeholder="Employee Company"
                              :errors="errors" endpoint="/api/companies" @update:field="form.company_id = $event" />
                <input-field name="email" label="Email" placeholder="Employee Email"
                             :errors="errors" @update:field="form.email = $event" />
                <input-field name="phone" label="Phone" placeholder="Employee Phone"
                             :errors="errors" @update:field="form.phone = $event" />
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
    import SelectField from "../components/SelectField";

    export default {
        name: "employees-create",

        components: {
            SelectField,
            InputField
        },

        data: function () {
            return {
                form: {
                    'first_name': '',
                    'last_name': '',
                    'company_id': '',
                    'email': '',
                    'phone': ''
                },

                errors: null
            }
        },

        methods: {
            submitForm: function () {
                axios.post('/api/employees', this.form)
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