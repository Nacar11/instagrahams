<script setup>
import { reactive, toRefs } from "vue";
import { Head, Link, router } from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";
import ContentOverlay from "@/Components/ContentOverlay.vue";
import ShowPostOverlay from "@/Components/ShowPostOverlay.vue";

import Cog from "vue-material-design-icons/Cog.vue";
import Grid from "vue-material-design-icons/Grid.vue";
import PlayBoxOutline from "vue-material-design-icons/PlayBoxOutline.vue";
import BookmarkOutline from "vue-material-design-icons/BookmarkOutline.vue";
import AccountBoxOutline from "vue-material-design-icons/AccountBoxOutline.vue";

let data = reactive({ post: null });
const form = reactive({ file: null });

const props = defineProps({ postsByUser: Object, user: Object });
const { postsByUser, user } = toRefs(props);

const setDefaultPicture = (e) => {
    console.log(user.value);
    console.log(e.target.files[0]);
    form.file = e.target.files[0];
    router.post("/users", form, {
        preserveState: false,
    });
};

const addComment = (object) => {
    router.post(
        "/comments",
        {
            post_id: object.post.id,
            user_id: object.user.id,
            comment: object.commentOut,
        },

        {
            onFinish: () => {
                updatedPost(object);
            },
        }
    );
};

const deleteFunc = (object) => {
    let url = "";
    console.log(object);
    if (object.deleteType === "Post") {
        url = "/posts/" + object.post.id;
        setTimeout(() => (data.post = null), 100);
    } else {
        url = "/comments/" + object.id;
    }

    router.delete(url, {
        onFinish: () => updatedPost(object),
    });
};

const updateLike = (object) => {
    let deleteLike = false;
    let id = null;
    console.log(object.post.likes.length);
    for (let i = 0; i < object.post.likes.length; i++) {
        console.log(object.post.likes);
        const like = object.post.likes[i];

        if (
            like.user_id === object.user.id &&
            like.post_id === object.post.id
        ) {
            deleteLike = true;
            id = like.id;
        }
    }
    if (deleteLike) {
        router.delete("/likes/" + id, {
            onFinish: () => {
                updatedPost(object);
            },
        });
    } else {
        router.post(
            "/likes",
            {
                post_id: object.post.id,
            },
            {
                onFinish: () => {
                    updatedPost(object);
                },
            }
        );
    }
};

const updatedPost = (object) => {
    for (let i = 0; i < postsByUser.value.data.length; i++) {
        const post = postsByUser.value.data[i];

        if (post.id === object.post.id) {
            data.post = post;
        }
    }
};
</script>

<template>
    <Head title="User" />
    <MainLayout>
        <div class="pt-2 md:pt-6">
            <div class="max-w-[880px] lg:ml-0[80px] md:pl-20 px-4 w-[100vw]">
                <div class="flex items-center md:justify-between">
                    <label
                        for="DefaultPicture"
                        class="rounded-lg p-2.5 text-white font-extrabold cursor-pointer"
                    >
                        <img
                            class="rounded-full object-fit md:w-[200px] w-[100px] cursor-pointer"
                            :src="user.file"
                        />
                    </label>
                    <input
                        v-if="user.id === $page.props.auth.user.id"
                        id="DefaultPicture"
                        class="hidden"
                        type="file"
                        @input="($event) => setDefaultPicture($event)"
                    />
                    <div class="ml-6 w-full">
                        <div class="flex items-center md:mb-8 mb-5">
                            <div class="md:mr-6 mr-3 rounded-lg text-[22px]">
                                {{ user.first_name }}
                                {{ user.last_name }}
                            </div>
                            <button
                                class="md:block hidden md:mr-6 mx-3 p-1 px-4 rounded-lg text-[16px] font-extrabold bg-gray-100 hover:bg-gray-200"
                            >
                                Edit Profile
                            </button>
                            <Cog :size="28" class="cursor-pointer" />
                        </div>
                        <button
                            class="md:hidden md:mr-6 mt-2 p-1 px-4 max-w-[260px] w-full rounded-lg text-[17px] font-extrabold bg-gray-100 hover:bg-gray-200"
                        >
                            Edit Profile
                        </button>
                        <div class="md:block hidden">
                            <div class="flex items-center text-[18px]">
                                <div class="mr-6">
                                    <span class="font-extrabold">{{
                                        postsByUser.data.length
                                    }}</span>
                                    posts
                                </div>
                                <div class="mr-6">
                                    <span class="font-extrabold">{{
                                        postsByUser.data.length + 109
                                    }}</span>
                                    followers
                                </div>
                                <div class="mr-6">
                                    <span class="font-extrabold">{{
                                        postsByUser.data.length + 131
                                    }}</span>
                                    following
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="md:hidden">
                <div
                    class="w-full flex items-center justify-around border-t border-t-gray-300 mt-8"
                >
                    <div class="text-center p-3">
                        <div class="font-extrabold">4</div>
                        <div class="text-gray-400 font-semibold -mt-1.5">
                            posts
                        </div>
                    </div>
                    <div class="text-center p-3">
                        <div class="font-extrabold">42</div>
                        <div class="text-gray-400 font-semibold -mt-1.5">
                            followers
                        </div>
                    </div>
                    <div class="text-center p-3">
                        <div class="font-extrabold">41</div>
                        <div class="text-gray-400 font-semibold -mt-1.5">
                            following
                        </div>
                    </div>
                </div>
                <div
                    class="w-full flex items-center justify-between border-t border-t-gray-300"
                >
                    <div
                        class="p-3 w-1/4 flex justify-center border-t border-t-gray-900"
                    >
                        <Grid
                            :size="28"
                            fillColor="#0095F6"
                            class="cursor-pointer"
                        />
                    </div>
                    <div class="p-3 w-1/4 flex justify-center">
                        <PlayBoxOutline
                            :size="28"
                            fillColor="#8E8E8E"
                            class="cursor-pointer"
                        />
                    </div>
                    <div class="p-3 w-1/4 flex justify-center">
                        <BookmarkOutline
                            :size="28"
                            fillColor="#0095F6"
                            class="cursor-pointer"
                        />
                    </div>
                    <div class="p-3 w-1/4 flex justify-center">
                        <AccountBoxOutline
                            :size="28"
                            fillColor="#0095F6"
                            class="cursor-pointer"
                        />
                    </div>
                </div>
            </div>
            <div id="ContentSection" class="md:pr-1.5 lg:pl-0 md:pl-[90px]">
                <div class="md:block mt-10 hidden border-t border-t-gray-300">
                    <div
                        class="flex items-center justify-between max-w-[600px] mx-auto font-extrabold text-gray-400 text-[15px]"
                    >
                        <div
                            class="p-[17px] w-1/4 flex justify-center items-center border-t border-t-gray-900"
                        >
                            <Grid
                                :size="15"
                                fillColor="#000000"
                                class="cursor-pointer"
                            />
                            <div class="ml-2 -mb-[1px] text-gray-900">
                                POSTS
                            </div>
                        </div>
                        <div
                            class="p-[17px] w-1/4 flex justify-center items-center"
                        >
                            <PlayBoxOutline
                                :size="15"
                                fillColor="#8E8E8E"
                                class="cursor-pointer"
                            />
                            <div class="ml-2 -mb-[1px]">REELS</div>
                        </div>
                        <div
                            class="p-[17px] w-1/4 flex justify-center items-center"
                        >
                            <BookmarkOutline
                                :size="15"
                                fillColor="#8E8E8E"
                                class="cursor-pointer"
                            />
                            <span class="ml-2 -mb-[1px]"> SAVED </span>
                        </div>
                        <div
                            class="p-[17px] w-1/4 flex justify-center items-center"
                        >
                            <AccountBoxOutline
                                :size="15"
                                fillColor="#8E8E8E"
                                class="cursor-pointer"
                            />
                            <span class="ml-2 -mb-[1px]"> TAGGED </span>
                        </div>
                    </div>
                </div>
                <div class="grid md:gap-4 gap-1 grid-cols-3 relative">
                    <div v-for="post in postsByUser.data" :key="post">
                        <ContentOverlay
                            :postByUser="post"
                            @selectedPost="
                                ($event) => {
                                    data.post = $event;
                                }
                            "
                        />
                    </div>
                </div>
                <div class="pb-20"></div>
            </div>
        </div>
    </MainLayout>
    <ShowPostOverlay
        v-if="data.post"
        :post="data.post"
        @closeOverlay="
            ($event) => {
                data.post = null;
            }
        "
        @updateLike="($event) => updateLike($event)"
        @addComment="($event) => addComment($event)"
        @deleteSelected="
            ($event) => {
                console.log($event);
                deleteFunc($event);
            }
        "
    />
</template>
