<template>
    <div class="drag-drop mt-2">
        <div v-show="$refs.upload && $refs.upload.dropActive" class="drop-active">
    		<h3>Drop files to upload</h3>
        </div>

        <div class="flex justify-center items-center w-full">
            <label v-if="!files.length" for="file" class="flex flex-col justify-center items-center w-full h-64 bg-gray-50 rounded-lg border-2 border-gray-300 border-dashed cursor-pointer hover:bg-gray-100">
                <div class="flex flex-col justify-center items-center pt-5 pb-6">
                    <svg class="mb-3 w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">JPG, JPEG, PNG or GIF</p>
                </div>
            </label>

            <file-upload
                name="file"
                ref="upload"
                v-model="files"
                :post-action="postAction"
                @input-file="inputFile"
                @input-filter="inputFilter"
                :drop="files.length==0 ? true : false"
            >
            </file-upload>
        </div>

        <div v-if="files.length!=0" class="relative overflow-x-auto mt-1 shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            #
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Thumb
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Size
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <span class="sr-only">Edit</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(file, index) in files" :key="file.id" class="bg-white border-b hover:bg-gray-50">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                            {{ index }}
                        </th>
                        <td class="px-6 py-4">
                            <img class="td-image-thumb" v-if="file.thumb" :src="file.thumb" />
                        </td>
                        <td class="px-6 py-4">
                            <div>
                                {{ file.name }}
                            </div>

                            <div class="progress" v-if="file.active || file.progress !== '0.00'">
                                <div :class="{'progress-bar': true, 'progress-bar-striped': true, 'bg-danger': file.error, 'progress-bar-animated': file.active}" role="progressbar" :style="{width: file.progress + '%'}">{{file.progress}}%</div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            {{ file.size }}
                        </td>

                        <td class="px-6 py-4" v-if="file.error">{{file.response.errors[0].detail}}</td>
                        <td class="px-6 py-4" v-else-if="file.success">success</td>
                        <td class="px-6 py-4" v-else-if="file.active">active</td>
                        <td class="px-6 py-4" v-else></td>

                        <td class="px-6 py-4 text-right">
                            <a class="font-medium text-blue-600 dark:text-blue-500 hover:underline" v-show="!$refs.upload || !$refs.upload.active" @click.prevent="$refs.upload.update(file, {active: true})" type="button">upload</a>
                            |
                            <a class="font-medium text-blue-600 dark:text-blue-500 hover:underline" v-show="!$refs.upload || !$refs.upload.active" @click.prevent="$refs.upload.remove(file)" type="button">remove</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import FileUpload from 'vue-upload-component'

export default {
    name: 'TheUploadFile',

    components: {
        FileUpload,
    },

    data() {
        return {
            files: [],
        }
    },

    methods: {
        coba(file) {
            this.$refs.upload.update(file, {active: false})
        },

        inputFile: function(newFile, oldFile) {
            // add
            if (newFile && !oldFile) {

            }

            // update
            if (newFile && oldFile) {
                if (newFile.success) {
                    this.$refs.upload.remove(newFile)
                }
            }

            // remove
            if (!newFile && oldFile) {

            }

            // if (newFile && oldFile && !newFile.active && oldFile.active) {
            //     // Get response data
            //     console.log('response', newFile.response)
            //     if (newFile.xhr) {
            //         //  Get the response status code
            //         console.log('status', newFile.xhr.status)
            //     }
            // }
        },

        inputFilter: function(newFile, oldFile, prevent) {
            if (newFile && !oldFile) {
                // Before adding a file
                // Filter system files or hide files
                if (/(\/|^)(Thumbs\.db|desktop\.ini|\..+)$/.test(newFile.name)) {
                    return prevent()
                }
                
                // Filter php html js file
                if (/\.(php5?|html?|jsx?)$/i.test(newFile.name)) {
                    return prevent()
                }

                newFile.blob = ''
                let URL = window.URL || window.webkitURL
                if (URL && URL.createObjectURL) {
                    newFile.blob = URL.createObjectURL(newFile.file)
                }

                newFile.thumb = ''
                if (newFile.blob && newFile.type.substr(0, 6) === 'image/') {
                    newFile.thumb = newFile.blob
                }
            }
        }
    },

    props: {
        postAction: String
    }
}
</script>

<style scoped>
.drag-drop .drop-active {
    top: 0;
    bottom: 0;
    right: 0;
    left: 0;
    position: fixed;
    z-index: 9999;
    opacity: .6;
    text-align: center;
    background: #000;
}

.drag-drop .drop-active h3 {
    margin: -.5em 0 0;
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    -webkit-transform: translateY(-50%);
    -ms-transform: translateY(-50%);
    transform: translateY(-50%);
    font-size: 40px;
    color: #fff;
    padding: 0;
}

.td-image-thumb {
    max-width: 4em;
    max-height: 4em;
}
</style>
