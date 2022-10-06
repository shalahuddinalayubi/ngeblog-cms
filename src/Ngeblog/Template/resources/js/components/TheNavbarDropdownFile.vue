<template>
    <div class="flex justify-center">
        <div class="relative">
            <button @click="dropdownOpen = !dropdownOpen" class="block px-5 py-2 mr-2 rounded-lg bg-blue-500 hover:bg-blue-700 text-white">
                File
            </button>

            <div v-show="dropdownOpen" @click="dropdownOpen = false" class="fixed inset-0 h-full w-full z-10">
            </div>

            <div v-show="dropdownOpen" class="absolute left-0 mt-2 py-2 w-48 bg-white rounded-md shadow-xl z-20">
                <a :href=filesIndex class="block px-4 py-2 text-sm capitalize text-gray-700 hover:bg-blue-500 hover:text-white">
                    Files
                </a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'TheNavbarDropdownFile',

        data() {
            return {
                dropdownOpen: false
            }
        },

        props: {
            filesIndex: String
        }
    }
</script>
