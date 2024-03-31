<script setup>
import { ref, toRefs } from "vue";
import { router, usePage } from "@inertiajs/vue3";

import Heart from "vue-material-design-icons/HeartOutline.vue";
import Comment from "vue-material-design-icons/CommentOutLine.vue";

defineEmits(["selectedPost"]);
const props = defineProps(["postByUser"]);
const { postByUser } = toRefs(props);
let isHover = ref(false);
</script>

<template>
    <div
        @mouseenter="($event) => (isHover = true)"
        @mouseleave="($event) => (isHover = false)"
        class="bg-black flex items-center justify-center cursor-pointer relative"
        @click="($event) => $emit('selectedPost', postByUser)"
    >
        <div
            v-if="isHover"
            :class="isHover ? 'bg-black bg-opacity-40' : ''"
            class="absolute w-full h-full z-50 flex items-center justify-around text-lg font-extrabold text-white"
        >
            <div class="flex items-center justify-around w-[50%]">
                <div class="flex items-center justify-center">
                    <Heart fillColor="#FFFFFF" :size="30" />
                    <div class="pl-1">{{ postByUser.likes.length }}</div>
                </div>
                <div class="flex items-center justify-center">
                    <Comment fillColor="#FFFFFF" :size="30" />
                    <div class="pl-1">{{ postByUser.comments.length }}</div>
                </div>
            </div>
        </div>
        <img
            class="aspect-square mx-auto z-10 object-cover cursor-pointer"
            :src="postByUser.file"
        />
    </div>
</template>
