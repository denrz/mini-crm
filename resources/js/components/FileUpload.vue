<template>
    <div class="row">
        <div class="col-md-2">
            <img :src="image">
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <div class="custom-file">
                    <input type="file" v-on:change="onFileChange" id="customFile" class="custom-file-input">
                    <label class="custom-file-label" for="customFile">Choose file</label>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary" @click="upload">Upload</button>
        </div>
    </div>
</template>

<script>
    export default {
        name: "file-upload",

        data: function() {
            return {
                image: ''
            }
        },

        methods: {
            onFileChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);
            },
            createImage(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.image = e.target.result;
                };
                reader.readAsDataURL(file);
            },
            upload(){
                axios.post('/api/image/upload', {image: this.image}).then(response => {

                });
            }
        }
    }
</script>

<style scoped>
    img{
        max-height: 100px;
        margin-left: 20px;
    }
</style>