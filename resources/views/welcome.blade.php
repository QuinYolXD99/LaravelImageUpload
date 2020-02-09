<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <!-- Styles -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.3.1/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.3.1/dist/js/uikit-icons.min.js"></script>
    <script src="{{asset('js/app.js')}}"></script>


</head>

<body>
    <div id="app">

        <div class="uk-cover-container">
            <div class="uk-card uk-card-primary uk-card-body">
                <h3 class="uk-card-title">Image Upload Using Laravel , Vue , Ui Kit and Axios</h3>
            </div>
        </div>
        <br>
        <div class="uk-container-xsmall">
            <div class="uk-card uk-card-default">
                <div class="uk-card-media-top">
                    <img :src="img_url" id="preview">
                </div>
                <div class="uk-card-body">

                    <div class="uk-margin">
                        <div v-if="show" :class="!success ? 'uk-alert-danger' : 'uk-alert-success'" uk-alert>
                            <a class="uk-alert-close" uk-close></a>
                            <p v-text="!success ? 'Failed' : 'Success'"></p>
                        </div>
                        <div uk-form-custom>
                            <input type="file" v-on:change="preview">
                            <button class="uk-button uk-width-1-1 uk-margin-small-bottoms uk-button-primary" type="button"
                                tabindex="-1"><span uk-icon="icon: camera"></span>
                                Select </button>

                        </div>
                        <button class="uk-button uk-button-secondary" v-text="tag" @click="upload" :disabled="uploading">Upload
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>



    <script>

        new Vue({
            el: '#app',
            data() {
                return {
                    image: "",
                    success: false,
                    img_url: "",
                    show: false,
                    uploading: false,
                    tag: "Upload"
                }
            },
            watch: {
                img_url() { }
            },
            methods: {
                encode: async file => {
                    let result_base64 = await new Promise(resolve => {
                        let fileReader = new FileReader();
                        fileReader.onload = e => {
                            console.log(typeof e);
                            resolve(fileReader.result);
                        };
                        fileReader.readAsDataURL(file);
                    });
                    return result_base64;
                },
                preview(e) {
                    this.image = e.target.files[0];
                    this.encode(this.image).then(res => {
                        this.img_url = res;
                    });

                },
                upload() {
                    const config = {
                        headers: { 'content-type': 'multipart/form-data' }
                    }
                    this.uploading = true;
                    let formData = new FormData();
                    formData.append('image', this.image);
                    this.tag = "Uploading..."
                    axios.post('/upload', formData, config)
                        .then((response) => {
                            this.success = true;
                            this.tag = "Upload";
                            this.uploading = false;
                            UIkit.notification({
                                message: '<div class="uk-alert-primary" uk-alert><a class= "uk-alert-close" uk-close ></a><p>Success!</p></div>',
                                status: 'success',
                                pos: 'bottom-center',
                                timeout: 2000
                            });

                        })
                        .catch((error) => {
                            this.tag = "Upload";
                            this.uploading = false;
                            this.success = false;
                            UIkit.notification({
                                message: '<div class="uk-alert-danger" uk-alert><a class= "uk-alert-close" uk-close ></a><p>Error!</p></div>',
                                status: 'danger',
                                pos: 'bottom-center',
                                timeout: 2000
                            });
                        });
                }
            },
            mounted() {

            },
        });



    </script>
</body>

</html>