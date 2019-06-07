<!--
    File Uploader Component:
    props:
        labelPlaceholder | String | default: 'No file choosen',
        uploadUrl | String | default: '/blog/image-upload/',
    emit: 'uploaded' with the 'response' from the server.

    use:
    <file-uploader @uploaded="getPostImage"></file-upload>
-->

<template>
    <div>
        <div class="c-file-input">
            <div class="c-file-input__indicator">
                <span class="c-file-input__indicator__icon c-icon c-icon--attach">
                    <i class="fas fa-paperclip"></i>
                </span>
            </div>
            <label class="c-file-input__label" for="inputfile">
                <span>{{ fileName }}</span>
                <input id="inputfile"
                       v-validate="'dimensions:1200,300'"
                       type="file"
                       @change="fileChangeHandler"
                       name="file"
                       class="c-file-input__field">
            </label>
            <div v-if="uploaded" class="c-file-input__status">
                <span class="c-file-input__done">
                    <i class="fas fa-check-circle"></i>
                </span>
            </div>
        </div>

        <span v-if="!uploaded" class="text-danger">{{ errors.first('file') }}</span>
    </div>
</template>

<script>
    export default {
        props: {
            labelPlaceholder: {
                type: String,
                default: 'No file choosen',
            },
            uploadUrl: {
                type: String,
                default: '/blog/panel/image-upload',
            }
        },
        data() {
            return {
                value: '',
                files: '',
                uploaded: false,
            };
        },
        computed: {
            fileName() {
                return this.files ? this.files.name : this.labelPlaceholder;
            },
        },
        methods: {
            fileChangeHandler(e) {
                let formData = new FormData();
                formData.set('file', _.first(e.target.files));

                axios.post(this.uploadUrl, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    }
                })
                .then(response => {
                    this.$emit('uploaded', response);
                    this.uploaded = true;
                });
            },
        },
    }
</script>

<style scoped>
    .c-file-input {
        position: relative;
        display: block;
        height: 36px;
        border: 1px dashed #ddd;
        background-color: #fff;
    }

    .c-file-input:invalid,
    .c-field--error .c-file-input {
        background-color: #ffe6e9;
        border-color: #ff566a;
    }

    .c-file-input:invalid:focus,
    .c-field--error .c-file-input:focus {
        background-color: #ffe6e9;
        border-color: #ff566a;
    }

    .c-file-input__label {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        padding-left: 36px;
        padding-right: 36px;
        line-height: 36px;
        color: #999;
        font-size: 12px;
        overflow: hidden;
        word-wrap: break-word;
        z-index: 1;
        cursor: pointer;
    }

    .c-file-input__field {
        position: absolute !important;
        height: 1px !important;
        width: 1px !important;
        padding: 0 !important;
        overflow: hidden !important;
        clip: rect(0, 0, 0, 0) !important;
        z-index: -1;
    }

    .c-file-input__field:focus {
        outline: none;
    }

    .c-file-input__indicator {
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 36px;
        z-index: 2;
    }

    .c-file-input__indicator__icon {
        color       : #bbb;
        left        : 10px;
        position    : absolute;
        top         : 7px;
    }

    .c-file-input__status {
        color       : #38c172;
        height      : 100%;
        position    : absolute;
        right       : 0;
        top         : 0;
        width       : 36px;
        z-index     : 2;
    }
    .c-file-input__done {
        position : absolute;
        right    : 10px;
        top      : 5px;
    }
</style>
