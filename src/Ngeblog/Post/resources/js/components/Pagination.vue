<template>
    <div class="pagination">
        <span v-for="(item, index) in pagination()" :key="index">
            <a href="#"
                @click="pageClicked(item)"
                :class="{ active: isActivePage(item), disabled: isNaN(item) }">
                {{ item }}
            </a>
        </span>
    </div>
</template>

<script>
export default {
    name: "Pagination",

    data: function () {
        return {
        }
    },

    methods: {
        pagination: function () {
            var delta = 2
            var left = this.currentPage - delta
            var right = this.currentPage + delta + 1
            var range = []
            var rangeWithDots = []
            var l

            for (let i = 1; i <= this.getTotalPages(); i++) {
                if (i == 1 || i == this.getTotalPages() || i >= left && i < right) {
                    range.push(i)
                }
            }

            for (let i of range) {
                if (l) {
                    if (i - l === 2) {
                        rangeWithDots.push(l + 1)
                    } else if (i - l !== 1) {
                        rangeWithDots.push('...')
                    }
                }

                rangeWithDots.push(i)
                l = i
            }

            return rangeWithDots
        },

        pageClicked: function (pageNumber) {
            this.$emit("pageClicked", pageNumber)
        },

        isActivePage: function (page) {
            return (this.currentPage === page) ? true : false
        },

        getTotalPages: function () {
            return Math.ceil(this.total / this.perPage)
        }
    },

    props: {
        total: Number,
        perPage: Number,
        currentPage: Number
    }
}
</script>

<style>
    .pagination {
        display: inline-block;
    }

    .pagination a {
        color: black;
        float: left;
        padding: 8px 16px;
        text-decoration: none;
    }

    .pagination a.active {
        background-color: #4CAF50;
        color: white;
    }

    .pagination a:hover:not(.active) {
        background-color: #ddd;
    }

    a.disabled {
        pointer-events: none;
        cursor: default;
    }
</style>