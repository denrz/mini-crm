<template>
    <div class="form-group">
        <label :for="name">{{ label }}</label>
        <input class="form-control" :id="name"
               :placeholder="placeholder" :class="{'is-invalid': hasError}" v-model="value" @input="updateField()">
        <p class="text-red" v-text="errorMessage()"></p>
    </div>
</template>

<script>
    export default {
        name: "input-field",

        props: [
            'name', 'label', 'placeholder', 'errors', 'data'
        ],

        data: function() {
            return {
                value: ''
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