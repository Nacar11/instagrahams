<script setup>
import { computed, toRefs } from "vue";
import { usePage } from "@inertiajs/vue3";

import Heart from "vue-material-design-icons/Heart.vue";
import HeartOutline from "vue-material-design-icons/HeartOutline.vue";
import CommentOutLine from "vue-material-design-icons/CommentOutLine.vue";
import SendOutline from "vue-material-design-icons/SendOutline.vue";
import BookmarkOutline from "vue-material-design-icons/BookmarkOutline.vue";

// const user = usePage().props.auth.user

const props = defineProps(["post"]);
const { post } = toRefs(props);
const emit = defineEmits(["like"]);
</script>

<template>
    <div class="flex z-20 items-center justify-between">
        <div class="flex items-center">
            <button class="-mt-[14px] mr-2">
                <HeartOutline class="pl-3 cursor-pointer" :size="30" />
            </button>
            <button class="-mt-[14px] mr-2">
                <CommentOutLine class="pl-3 cursor-pointer" :size="30" />
            </button>
            <button class="-mt-[14px] mr-2">
                <SendOutline class="pl-3 cursor-pointer" :size="30" />
            </button>
        </div>
        <button class="-mt-[14px] mr-2">
            <BookmarkOutline class="pl-3 cursor-pointer" :size="30" />
        </button>
    </div>
</template>
