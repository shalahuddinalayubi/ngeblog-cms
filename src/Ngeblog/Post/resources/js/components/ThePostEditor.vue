<template>
    <div :class="{ 'error': hasError }">
        <div id="toolbar">
            <select class="ql-font">
                <option selected="selected"></option>
                <option value="serif"></option>
                <option value="monospace"></option>
            </select>

            <select class="ql-align">
                <option value="center"></option>
                <option value="right"></option>
                <option value="justify"></option>
            </select>

            <select class="ql-header">
                <option value="1"></option>
                <option value="2"></option>
                <option value="3"></option>
                <option value="4"></option>
                <option value="5"></option>
                <option value="6"></option>
                <option selected="selected"></option>
            </select>

            <select class="ql-size">
                <option value="small"></option>
                <option selected></option>
                <option value="large"></option>
                <option value="huge"></option>
            </select>

            <button type="button" class="ql-list" value="ordered">
                <svg viewBox="0 0 18 18">
                    <line class="ql-stroke" x1="7" x2="15" y1="4" y2="4"></line>
                    <line class="ql-stroke" x1="7" x2="15" y1="9" y2="9"></line>
                    <line class="ql-stroke" x1="7" x2="15" y1="14" y2="14"></line>
                    <line class="ql-stroke ql-thin" x1="2.5" x2="4.5" y1="5.5" y2="5.5"></line>
                    <path class="ql-fill" d="M3.5,6A0.5,0.5,0,0,1,3,5.5V3.085l-0.276.138A0.5,0.5,0,0,1,2.053,3c-0.124-.247-0.023-0.324.224-0.447l1-.5A0.5,0.5,0,0,1,4,2.5v3A0.5,0.5,0,0,1,3.5,6Z">
                    </path>
                    <path class="ql-stroke ql-thin" d="M4.5,10.5h-2c0-.234,1.85-1.076,1.85-2.234A0.959,0.959,0,0,0,2.5,8.156">
                    </path>
                    <path class="ql-stroke ql-thin" d="M2.5,14.846a0.959,0.959,0,0,0,1.85-.109A0.7,0.7,0,0,0,3.75,14a0.688,0.688,0,0,0,.6-0.736,0.959,0.959,0,0,0-1.85-.109">
                    </path>
                </svg>
            </button>

            <button type="button" class="ql-list" value="bullet">
                <svg viewBox="0 0 18 18">
                    <line class="ql-stroke" x1="6" x2="15" y1="4" y2="4"></line>
                    <line class="ql-stroke" x1="6" x2="15" y1="9" y2="9"></line>
                    <line class="ql-stroke" x1="6" x2="15" y1="14" y2="14"></line>
                    <line class="ql-stroke" x1="3" x2="3" y1="4" y2="4"></line>
                    <line class="ql-stroke" x1="3" x2="3" y1="9" y2="9"></line>
                    <line class="ql-stroke" x1="3" x2="3" y1="14" y2="14"></line>
                </svg>
            </button>

            <button class="ql-bold"></button>
            <button class="ql-italic"></button>
            <button class="ql-underline"></button>
            <button class="ql-strike"></button>
            <button class="ql-chooseImage">
                <svg viewBox="0 0 18 18"> <rect class="ql-stroke" height="10" width="12" x="3" y="4"></rect> <circle class="ql-fill" cx="6" cy="7" r="1"></circle> <polyline class="ql-even ql-fill" points="5 12 5 11 7 9 8 10 11 7 13 9 13 12 5 12"></polyline> </svg>
            </button>
        </div>

        <vue-editor
            ref="editor"
            v-model="content"
            :editor-toolbar="customToolbar"
            use-custom-image-handler
            :editor-options="editorOptions"
        />
        <textarea :name=name class="hidden" v-model="content"></textarea>

        <modal name="image" height="auto" :adaptive="true">
            <div class="m-3">
                <the-upload-file
                    :post-action="postAction">
                </the-upload-file>

                <loading :active="image.isLoading"
                    :can-cancel="true"/>

                <section class="overflow-hidden text-gray-700 ">
                    <div class="container px-5 py-2 mx-auto">
                        <div class="flex flex-wrap -m-1 md:-m-2">
                            <div class="flex flex-wrap w-1/3" v-for="image in image.data" :key="image.index">
                                <div class="w-full max-h-36 relative p-1 md:p-2"
                                    @click.prevent="addImageToEditor(image.attributes.url)">
                                    <div class="absolute inset-0 z-10 bg-white hover:cursor-pointer text-center flex flex-col items-center justify-center opacity-0 hover:opacity-100 bg-opacity-90 duration-300">
                                        <h1 class=tracking-wider>Click to insert</h1>
                                    </div>

                                    <img alt="gallery"
                                        class="block object-cover object-center hover:scale-110 transition-all hover:cursor-pointer w-full h-full rounded-lg"
                                        :src="image.attributes.url">
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <div class="flex w-full">
                    <pagination class="mx-auto"
                        :total="image.pagination.total"
                        :per-page="image.pagination.per_page"
                        :current-page="image.pagination.current_page"
                        :show-page="5"
                        @pageClicked="getPageNumber($event)"
                        />
                </div>
            </div>
        </modal>
    </div>
</template>

<script>
import { VueEditor } from "vue2-editor"
import axios from "axios"
import Loading from "vue-loading-overlay"

export default {
    name: 'ThePostEditor',

    data: function () {
        return {
            image: {
                isLoading: true,
                pagination: { },
                data: []
            },

            selection: { },

            images: [],

            content: '',
    
            editorOptions: {
                modules: {
                    toolbar: {
                        container: '#toolbar',
                        handlers: {
                            chooseImage: () => {
                                this.selection = this.$refs.editor.quill.getSelection()

                                this.$modal.show('image')
                                
                                axios.get('http://localhost:8000/api/files')
                                    .then((response) => {
                                        this.image.pagination['links'] = response.data.links
                                        Object.assign(this.image.pagination, response.data.meta.pagination)
                                        this.image.data = response.data.data
                                        this.image.isLoading = false
                                    })
                            }
                        }
                    }
                }
            },
    
            customToolbar: [
                ['bold', 'italic', 'underline', 'strike'],
                ['blockquote', 'code-block'],
    
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'script': 'sub'}, { 'script': 'super' }],
                [{ 'indent': '-1'}, { 'indent': '+1' }],
                [{ 'direction': 'rtl' }],
    
                [{ 'size': ['small', false, 'large', 'huge'] }],
                [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                [ 'image' ],
    
                [{ 'color': [] }, { 'background': [] }],
                [{ 'font': [] }],
                [{ 'align': ['center', 'right', 'justify'] }],
    
                ['clean']
            ]
        }
    },

    methods: {
        setValue() {
            this.content = this.value
        },

        addImageToEditor: function (url) {
            this.$modal.hide('image')
            this.$refs.editor.quill.insertEmbed(this.selection.index, 'image', url)
        },

        getPageNumber: function (pageNumber) {
            axios.get('http://localhost:8000/api/files', {
                    params: {
                        page: pageNumber
                    }
                }).then((response) => {
                    this.image.pagination['links'] = response.data.links
                    Object.assign(this.image.pagination, response.data.meta.pagination)
                    this.image.data = response.data.data
                })
        }
    },

    props: {
        value: String,
        name: String,
        hasError: {
            default: false
        },
        postAction: String
    },

    created() {
        this.setValue()
    },

    components: {
        VueEditor,
        Loading
    }
}
</script>

<style scoped>
    .error {
        border: 1px solid red;
    }
</style>
