<template>
    <div :class="{ 'error': hasError }">
        <vue-editor
            ref="editor"
            v-model="content"
            :editor-toolbar="customToolbar"
        />
        <textarea :name=name class="hidden" v-model="content"></textarea>
    </div>
</template>

<script>
import { VueEditor } from "vue2-editor"

export default {
    name: 'ThePostEditor',

    data: () => ({
        content: '',

        customToolbar: [
            ['bold', 'italic', 'underline', 'strike'],
            ['blockquote', 'code-block'],

            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            [{ 'script': 'sub'}, { 'script': 'super' }],
            [{ 'indent': '-1'}, { 'indent': '+1' }],
            [{ 'direction': 'rtl' }],

            [{ 'size': ['small', false, 'large', 'huge'] }],
            [{ 'header': [1, 2, 3, 4, 5, 6, false] }],

            [{ 'color': [] }, { 'background': [] }],
            [{ 'font': [] }],
            [{ 'align': ['center', 'right', 'justify'] }],

            ['clean']
        ]
    }),

    props: {
        value: String,
        name: String,
        hasError: {
            default: false
        }
    },

    methods: {
        setValue() {
            this.content = this.value
        }
    },

    created() {
        this.setValue()
    },

    components: {
        VueEditor
    }
}
</script>

<style scoped>
    .error {
        border: 1px solid red;
    }
</style>
