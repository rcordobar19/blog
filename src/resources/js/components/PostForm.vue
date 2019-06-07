<template>
    <form class="mt-3">
        <label for="post-image">Post Image</label>
        <div class="mb-3">
            <div class="mb-3 overflow-auto" v-if="form.post_image">
                <img :src="form.post_image" alt="" height="300">
            </div>
            <label for="post-image" v-if="form.post_image">...or upload a new one</label>
            <file-uploader id="post-image" @uploaded="getUploadedImage"></file-uploader>
            <small class="form-text text-muted">Suggested image size: 1200px x 300px.</small>
            <small class="form-text text-muted">Supported formats: jpg, png.</small>
        </div>

        <div class="form-group">
            <label for="title">Title</label>
            <input v-validate="'required'" name="title" id="title" v-model="form.title" @change="generateSlug" type="text" class="form-control">
            <span class="text-danger">{{ errors.first('title') }}</span>
        </div>

        <div class="form-group">
            <label for="slug">Slug</label>
            <input v-validate="'required'" name="slug" id="slug" v-model="form.slug" type="text" class="form-control">
            <span class="text-danger">{{ errors.first('slug') }}</span>
        </div>

        <div class="form-group">
            <label for="categories">Categories</label>
            <multiselect v-model="form.categories"
                         :options="allCategories"
                         :multiple="true"
                         :close-on-select="true"
                         placeholder="Pick some categories"
                         label="name"
                         track-by="id">
            </multiselect>
            <span class="text-danger">{{ errors.first('categories') }}</span>
        </div>

        <label>Content</label>
        <ckeditor v-validate="'required'" name="content" :editor="CKEditor" v-model="form.content"></ckeditor>
        <span class="text-danger">{{ errors.first('content') }}</span>

        <div class="form-group form-check mt-3">
            <input name="is_listed" v-model="form.featured" type="checkbox" class="form-check-input" id="featured">
            <label class="form-check-label" for="featured">Show in the Home (Featured Post)</label>
        </div>

        <button type="button" class="btn btn-outline-primary" @click.submit.prevent="savePost">Save</button>
        <button type="button" class="btn btn-outline-secondary" @click.submit.prevent="previewPost">Preview</button>
        <button type="button" class="btn btn-outline-success" v-if="!form.published" @click.submit.prevent="publishPost">Publish</button>
    </form>
</template>

<script>
    import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

    export default {
        props: {
            post: {
                type: Object,
                default: () => ({}),
            },
            action: {
                type: String,
                default: 'create',
            },
            actionUrl: {
                type: String,
            }
        },
        data() {
            return {
                CKEditor: ClassicEditor,
                form: {
                    categories: '',
                    content: '',
                    featured: false,
                    post_image: '/vendor/blog/images/default/post-image.png',
                    preview_image: '/vendor/blog/images/default/preview-image.png',
                    published: false,
                    published_at: '',
                    slug: '',
                    title: '',
                },
                allCategories: [],
                saveAction: this.action,
            };
        },
        created() {
            // If we are editing then populate form with post prop.
            if (this.action === 'edit') { this.form = this.post; }

            this.getAllCategories();
        },
        methods: {
            getAllCategories() {
                axios.get('/blog/api/categories')
                    .then(response => {
                        this.allCategories = response.data;
                    })
                    .catch(error => {});
            },

            generateSlug() {
                if(!this.form.title) { return; }
                this.form.slug = this.form.title.toString()
                    .toLowerCase()
                    .replace(/\s+/g, '-') // Replace spaces with -
                    .replace(/&/g, '-and-') // Replace & with 'and'
                    .replace(/[^\w\-]+/g, '') // Remove all non-word chars
                    .replace(/--+/g, '-'); // Replace multiple - with single -
            },

            getUploadedImage(response) {
                this.form.post_image = response.data.post_image_path;
                this.form.preview_image = response.data.preview_image_path;
            },

            previewPost() {
                this.savePost();

                window.open('/blog/' + this.form.slug);
            },

            publishPost() {
                // The publication occurs in the backend
                this.form.published = true;

                this.savePost();
            },

            savePost() {
                let data = this.form;

                if (this.saveAction === 'create'){
                    var method = 'post';
                    var url = '/blog/panel';
                }

                if (this.saveAction === 'edit'){
                    var method = 'put';
                    var url = '/blog/panel/' + this.form.id;
                }

                this.$validator.validateAll().then((result) => {
                    if (result) {
                        axios({method, url, data})
                            .then(response => {
                                this.form = response.data.data;

                                this.showSuccessMessage(response.data.message, 'success');

                                this.saveAction = 'edit';
                            }).catch(error => {
                                this.$setLaravelValidationErrorsFromResponse(error.response.data);

                                this.$swal(
                                    'There are some errors!',
                                    'Please fix form issues.',
                                    'error'
                                );
                        });
                    }
                });
            },

            showSuccessMessage(message) {
                this.$swal({
                    title: '<strong>' + message + '</strong>',
                    type: 'success',
                    html:
                        'Do you want to check the new post?',
                    showCloseButton: true,
                    showCancelButton: true,
                    focusConfirm: true,
                    confirmButtonText:
                        '<i class="fa fa-thumbs-up"></i> Yeah!',
                    cancelButtonText:
                        '<i class="fa fa-thumbs-down"></i> No',
                }).then((result) => {
                    if(result.value) {
                        window.location.href = '/blog/' + this.form.slug;
                    }
                });
            },
        }
    }
</script>

<style>
    /* MultiSelect Style.*/
    fieldset[disabled] .multiselect{pointer-events:none}.multiselect__spinner{position:absolute;right:1px;top:1px;width:48px;height:35px;background:#fff;display:block}.multiselect__spinner:after,.multiselect__spinner:before{position:absolute;content:"";top:50%;left:50%;margin:-8px 0 0 -8px;width:16px;height:16px;border-radius:100%;border:2px solid transparent;border-top-color:#41b883;box-shadow:0 0 0 1px transparent}.multiselect__spinner:before{animation:spinning 2.4s cubic-bezier(.41,.26,.2,.62);animation-iteration-count:infinite}.multiselect__spinner:after{animation:spinning 2.4s cubic-bezier(.51,.09,.21,.8);animation-iteration-count:infinite}.multiselect__loading-enter-active,.multiselect__loading-leave-active{transition:opacity .4s ease-in-out;opacity:1}.multiselect__loading-enter,.multiselect__loading-leave-active{opacity:0}.multiselect,.multiselect__input,.multiselect__single{font-family:inherit;font-size:16px;-ms-touch-action:manipulation;touch-action:manipulation}.multiselect{box-sizing:content-box;display:block;position:relative;width:100%;min-height:40px;text-align:left;color:#35495e}.multiselect *{box-sizing:border-box}.multiselect:focus{outline:none}.multiselect--disabled{background:#ededed;pointer-events:none;opacity:.6}.multiselect--active{z-index:50}.multiselect--active:not(.multiselect--above) .multiselect__current,.multiselect--active:not(.multiselect--above) .multiselect__input,.multiselect--active:not(.multiselect--above) .multiselect__tags{border-bottom-left-radius:0;border-bottom-right-radius:0}.multiselect--active .multiselect__select{transform:rotate(180deg)}.multiselect--above.multiselect--active .multiselect__current,.multiselect--above.multiselect--active .multiselect__input,.multiselect--above.multiselect--active .multiselect__tags{border-top-left-radius:0;border-top-right-radius:0}.multiselect__input,.multiselect__single{position:relative;display:inline-block;min-height:20px;line-height:20px;border:none;border-radius:5px;background:#fff;padding:0 0 0 5px;width:100%;transition:border .1s ease;box-sizing:border-box;margin-bottom:8px;vertical-align:top}.multiselect__input:-ms-input-placeholder{color:#35495e}.multiselect__input::placeholder{color:#35495e}.multiselect__tag~.multiselect__input,.multiselect__tag~.multiselect__single{width:auto}.multiselect__input:hover,.multiselect__single:hover{border-color:#cfcfcf}.multiselect__input:focus,.multiselect__single:focus{border-color:#a8a8a8;outline:none}.multiselect__single{padding-left:5px;margin-bottom:8px}.multiselect__tags-wrap{display:inline}.multiselect__tags{min-height:40px;display:block;padding:8px 40px 0 8px;border-radius:5px;border:1px solid #e8e8e8;background:#fff;font-size:14px}.multiselect__tag{position:relative;display:inline-block;padding:4px 26px 4px 10px;border-radius:5px;margin-right:10px;color:#fff;line-height:1;background:#41b883;margin-bottom:5px;white-space:nowrap;overflow:hidden;max-width:100%;text-overflow:ellipsis}.multiselect__tag-icon{cursor:pointer;margin-left:7px;position:absolute;right:0;top:0;bottom:0;font-weight:700;font-style:normal;width:22px;text-align:center;line-height:22px;transition:all .2s ease;border-radius:5px}.multiselect__tag-icon:after{content:"\D7";color:#266d4d;font-size:14px}.multiselect__tag-icon:focus,.multiselect__tag-icon:hover{background:#369a6e}.multiselect__tag-icon:focus:after,.multiselect__tag-icon:hover:after{color:#fff}.multiselect__current{min-height:40px;overflow:hidden;padding:8px 30px 0 12px;white-space:nowrap;border-radius:5px;border:1px solid #e8e8e8}.multiselect__current,.multiselect__select{line-height:16px;box-sizing:border-box;display:block;margin:0;text-decoration:none;cursor:pointer}.multiselect__select{position:absolute;width:40px;height:38px;right:1px;top:1px;padding:4px 8px;text-align:center;transition:transform .2s ease}.multiselect__select:before{position:relative;right:0;top:65%;color:#999;margin-top:4px;border-color:#999 transparent transparent;border-style:solid;border-width:5px 5px 0;content:""}.multiselect__placeholder{color:#adadad;display:inline-block;margin-bottom:10px;padding-top:2px}.multiselect--active .multiselect__placeholder{display:none}.multiselect__content-wrapper{position:absolute;display:block;background:#fff;width:100%;max-height:240px;overflow:auto;border:1px solid #e8e8e8;border-top:none;border-bottom-left-radius:5px;border-bottom-right-radius:5px;z-index:50;-webkit-overflow-scrolling:touch}.multiselect__content{list-style:none;display:inline-block;padding:0;margin:0;min-width:100%;vertical-align:top}.multiselect--above .multiselect__content-wrapper{bottom:100%;border-bottom-left-radius:0;border-bottom-right-radius:0;border-top-left-radius:5px;border-top-right-radius:5px;border-bottom:none;border-top:1px solid #e8e8e8}.multiselect__content::webkit-scrollbar{display:none}.multiselect__element{display:block}.multiselect__option{display:block;padding:12px;min-height:40px;line-height:16px;text-decoration:none;text-transform:none;vertical-align:middle;position:relative;cursor:pointer;white-space:nowrap}.multiselect__option:after{top:0;right:0;position:absolute;line-height:40px;padding-right:12px;padding-left:20px;font-size:13px}.multiselect__option--highlight{background:#41b883;outline:none;color:#fff}.multiselect__option--highlight:after{content:attr(data-select);background:#41b883;color:#fff}.multiselect__option--selected{background:#f3f3f3;color:#35495e;font-weight:700}.multiselect__option--selected:after{content:attr(data-selected);color:silver}.multiselect__option--selected.multiselect__option--highlight{background:#ff6a6a;color:#fff}.multiselect__option--selected.multiselect__option--highlight:after{background:#ff6a6a;content:attr(data-deselect);color:#fff}.multiselect--disabled .multiselect__current,.multiselect--disabled .multiselect__select{background:#ededed;color:#a6a6a6}.multiselect__option--disabled{background:#ededed!important;color:#a6a6a6!important;cursor:text;pointer-events:none}.multiselect__option--group{background:#ededed;color:#35495e}.multiselect__option--group.multiselect__option--highlight{background:#35495e;color:#fff}.multiselect__option--group.multiselect__option--highlight:after{background:#35495e}.multiselect__option--disabled.multiselect__option--highlight{background:#dedede}.multiselect__option--group-selected.multiselect__option--highlight{background:#ff6a6a;color:#fff}.multiselect__option--group-selected.multiselect__option--highlight:after{background:#ff6a6a;content:attr(data-deselect);color:#fff}.multiselect-enter-active,.multiselect-leave-active{transition:all .15s ease}.multiselect-enter,.multiselect-leave-active{opacity:0}.multiselect__strong{margin-bottom:8px;line-height:20px;display:inline-block;vertical-align:top}[dir=rtl] .multiselect{text-align:right}[dir=rtl] .multiselect__select{right:auto;left:1px}[dir=rtl] .multiselect__tags{padding:8px 8px 0 40px}[dir=rtl] .multiselect__content{text-align:right}[dir=rtl] .multiselect__option:after{right:auto;left:0}[dir=rtl] .multiselect__clear{right:auto;left:12px}[dir=rtl] .multiselect__spinner{right:auto;left:1px}@keyframes spinning{0%{transform:rotate(0)}to{transform:rotate(2turn)}}
</style>