import NotFound from "@/app/errors/components/NotFound";
import Forbidden from "@/app/errors/components/Forbidden";

export default [
    {
        path: "/403",
        component: Forbidden,
        name: "403",
        meta: {
            pageTitle: "403"
        }
    },
    {
        path: "*",
        component: NotFound,
        name: "404",
        meta: {
            pageTitle: "404"
        }
    }
];
