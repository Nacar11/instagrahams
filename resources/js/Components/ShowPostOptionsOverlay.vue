<script setup>
import { ref, toRefs } from "vue";
import { router, usePage } from "@inertiajs/vue3";

import LikesSection from "@/Components/LikesSection.vue";
import ShowPostOptionsOverlay from "@/Components/ShowPostOptionsOverlay.vue";
import Close from "vue-material-design-icons/close.vue";
import DotsHorizontal from "vue-material-design-icons/DotsHorizontal.vue";
import EmoticonHappyOutline from "vue-material-design-icons/EmoticonHappyOutline.vue";

// const user = usePage().props.auth.user

let comment = ref("");
let deleteType = ref(null);
let id = ref(null);

const props = defineProps(["post"]);
const { post } = toRefs(props);

defineEmits(["closeOverlay", "addComment", "updateLike", "deleteSelected"]);

const textAreaInput = (e) => {
    textArea.value.style.height = "auto";
    textArea.value.style.height = `${e.target.scrollHeight}px`;
};
</script>

<template>
    <div
        id="OverlaySection"
        class="fixed z-50 top-0 left-0 w-full h-screen bg-[#000000] bg-opacity-60 p-3"
    >
        <button
            class="absolute right-3"
            @click="($event) => $emit('closeOverlay')"
        >
            <Close :size="27" fillColor="#FFFFFF" />
        </button>
        <div
            class="max-w-6xl h-[calc(100%-100px)] mx-auto mt-10 bg-white rounded-xl"
        >
            <div class="w-full md:flex h-full overflow-auto rounded-xl">
                <div class="flex items-center bg-black w-full">
                    <img
                        class="rounded-xl min-x-[400px] p-4 mx-auto"
                        src="https://picsum.photos/id/54/300/320"
                    />
                </div>
                <div class="md:max-w-[500px] w-full relative">
                    <div class="flex items-center justify-between p-3 border-b">
                        <div class="flex items-center">
                            <img
                                class="rounded-full w-[38px] h-[38px]"
                                src="https://picsum.photos/id/54/300/320"
                            />
                            <div class="ml-4 font-extrabold text-[15px]">
                                Bran Dale Nacario
                            </div>
                            <div
                                class="flex items-center text-[15px] text-gray-500"
                            >
                                <span class="-mt-5 ml-2 mr-[5px] text-[35px]"
                                    >.
                                </span>
                                <div>Jan 12, 2024</div>
                            </div>
                        </div>
                        <button>
                            <DotsHorizontal class="cursor-pointer" :size="27" />
                        </button>
                    </div>
                    <div class="overflow-y-auto h-[calc(100%-170px)]">
                        <div class="flex items-center justify-between p-3">
                            <div class="flex items-center relative">
                                <img
                                    class="absolute -top-1 rounded-full w-[38px] h-[38px]"
                                    src="https://picsum.photos/id/54/300/320"
                                />
                                <div class="ml-14">
                                    <span
                                        class="font-extrabold text-[15px] mr-2"
                                    >
                                        Bran Dale Nacario
                                    </span>
                                    <span class="text-[15px] text-gray-900">
                                        I loveyouu!
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="p-3">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <img
                                        class="rounded-full w-[38px] h-[38px]"
                                        src="https://picsum.photos/id/54/300/320"
                                    />
                                    <div
                                        class="ml-4 font-extrabold text-[15px]"
                                    >
                                        Bran Dale Nacario
                                        <span
                                            class="font-light text-gray-700 text-sm"
                                        >
                                            July 12, 2024
                                        </span>
                                    </div>
                                </div>
                                <DotsHorizontal
                                    class="cursor-pointer"
                                    :size="27"
                                />
                            </div>
                            <div class="text-[13px] pl-[55px]">
                                COMMENT SECTION
                            </div>
                        </div>
                        <div class="pb-16 md:hidden"></div>
                    </div>
                    <LikesSection class="px-2 border-t mb-2" />
                    <div
                        class="absolute flex border bottom-0 w-full max-h-[200px] bg-white overflow-auto"
                    >
                        <EmoticonHappyOutline
                            class="pl-3 pt-[10px]"
                            :size="30"
                        />
                        <textarea
                            ref="textarea"
                            :oninput="textareaInput"
                            v-model="comment"
                            placeholder="Add a comment..."
                            rows="1"
                            class="w-full border-0 mt-2 mb-2 text-sm z-50 focus:ring-0 text-gray-600 text-[18px]"
                        ></textarea>
                        <button
                            v-if="comment"
                            class="text-blue-600 font-extrabold pr-4"
                        >
                            Post
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <ShowPostOptionsOverlay v-if="deleteType" />
</template>
