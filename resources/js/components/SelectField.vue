<template>
    <div class="form-group">
        <label :for="name">{{ label }}</label>
        <select class="form-control" :id="name"
                :placeholder="placeholder" v-model="value" @change="updateField()">
            <option></option>
            <option v-for="(option, name) in options" :value="option.data.company_id">{{ option.data.name }}</option>
        </select>
        <p class="text-red" v-text="errorMessage()"></p>
    </div>
</template>

<script>
    export default {
        name: "select-field",

        props: [
            'name', 'label', 'placeholder', 'errors', 'data', 'endpoint'
        ],

        mounted() {
            axios.get(this.endpoint)
                .then(response => {
                    this.options = response.data;
                })
                .catch(error => {
                    this.options = [];
                });
        },

        data: function() {
            return {
                value: '',
                options: ''
            }
        },

        computed: {
            hasError: function () {
                return this.errors && this.errors[this.name] && this.errors[this.name].length > 0
            }
        },

        methods: {
            updateField: function () {
                this.clearErrors();
                this.$emit('update:field', this.value);
            },
            errorMessage: function () {
                if (this.hasError) {
                    return this.errors[this.name][0];
                }
            },

            clearErrors: function () {
                if (this.hasError) {
                    this.errors[this.name] = null;
                }
            }
        },

        watch: {
            data: function (val) {
                this.value = val;
            }
        }
    }
</script>

<style scoped>

</style>