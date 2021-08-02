import PodcastIndex from "@/app/podcast/components/PodcastIndex";
import PodcastEdit from "@/app/podcast/components/PodcastEdit";
import { authGuard } from "../guards";

export default [
    {
        path: "/podcast",
        component: PodcastIndex,
        name: "podcast.index",
        meta: {
            pageTitle: "Podcast"
        },
        beforeEnter: authGuard
    },
    {
        path: "/podcast/:id/edit",
        component: PodcastEdit,
        name: "podcast.edit",
        meta: {
            pageTitle: "Edit Podcast"
        },
        beforeEnter: authGuard
    }
];
