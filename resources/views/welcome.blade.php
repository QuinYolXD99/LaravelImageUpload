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
    <script src="{{asset('js/app.js')}}"></script>

</head>

<body>
    <div id="app">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">

                        <div class="card-body">
                            <div v-if="success" class="alert alert-success" role="alert">
                                Success
                            </div>
                            <div class="row">
                                <img src="" id="preview" alt="">
                            </div>
                            <div class="row">

                                <strong>Image:</strong>
                                <input type="file" class="form-control" v-on:change="preview">
                                <br>
                                <button class="btn btn-success mt-2" @click="upload">Submit</button>
                            </div>
                        </div>
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
                    success: false
                }
            },
            methods: {
                preview(e) {
                    this.image = e.target.files[0];
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#preview').attr('src', e.target.result);


                    }
                    reader.readAsDataURL(this.image);


                },
                upload() {
                    const config = {
                        headers: { 'content-type': 'multipart/form-data' }
                    }

                    let formData = new FormData();
                    formData.append('image', this.image);

                    axios.post('/upload', formData, config)
                        .then((response) => {
                            this.success = true;
                        })
                        .catch((error) => {
                            this.success = false;
                        });
                }
            },
            mounted() {

            },
        });



    </script>
</body>

</html>