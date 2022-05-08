<template>
    <div class="container">
        <div class="row mt-4">
            <div class="col-12">
                <form @submit="uploadCsv" enctype="multipart/form-data">
                    <div class="input-group">
                        <div class="custom-file">
                            <input required type="file" name="file" class="custom-file-input" id="customFile"
                                v-on:change="readFile">
                            <label class="custom-file-label" for="customFile" id="label-file" ref="file">Select or Drag
                                and Drop File Here</label>

                        </div>
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-outline-secondary" id="uploadButton">Click Here to
                                Upload</button>
                        </div>
                    </div>
                </form>
                <p>Selected File : {{ filename }}</p>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12" id="app">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Time</th>
                            <th>FileName</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(batch, key) in batchs" :key="key">
                            <td>{{ batch.time.created }} ({{batch.time.minutes}})</td>
                            <td>{{ batch.name }}</td>
                            <td>{{ batch.progress }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</template>

<script>
import axios from "axios";

export default {
    name: 'BatchData',
    data() {
        return {
            batchs: [],
            filename: null,
            csvFiles: '',
        }
    },
    methods: {
        fetchBatch() {
            axios.get('/batch')
            .then((res) => {
                this.batchs = res.data;
            })
        },
        readFile(e) {
            this.filename = e.target.files[0].name;
            this.csvFiles = e.target.files[0];
        },
        uploadCsv(e) {
            e.preventDefault();

            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            };

            let formData = new FormData();
            formData.append('file', this.csvFiles);

            axios.request({
                method: "POST",
                url: '/',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                data: formData
            }).then((response) => {
                this.fetchBatch();
                this.filename = null;
            });
        }
    },
    mounted() {
        this.fetchBatch();
        setInterval(function () {
            this.fetchBatch();
        }.bind(this), 6000);
    },
    

}
</script>