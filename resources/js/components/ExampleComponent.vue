<template>
    <div class="container">
        <div class="row justify-content-center mb-3" ref="imageUpload">
            <div class="col-12 bg-dark text-white rounded py-3 my-2 text-center">Drop Images Here</div>
        </div>
    </div>
</template>

<script>
    import Dropzone from 'dropzone';

    export default {
        data: function() {
            return {
                dropzone: null
            }
        },
        // KAda je komponenta podignuta, kreira novi dropzone OBJ
        mounted() {
            // U konstruktoru nam treba aria gde cemo prevlaciti fajlove + opcioni parametri, obavezan je samo url gde cemo uploadovati fajlove
            // Sa ref tagom povezujemo hiv u html-u, pa mu iz vue pristupamo sa this.$refs.imageUpload
            this.dropzone = new Dropzone(this.$refs.imageUpload, {
                // Znaci da ce uraditi POST request to /images folderu
                url: '/api/images'
            });
        }
    }
</script>
