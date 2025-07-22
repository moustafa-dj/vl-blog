import { reactive } from "vue";

export const searchStore = reactive({
    search : null,

    setSearch(updatedSearch)
    {
        return this.search = updatedSearch
    },

    getSearch()
    {
        return this.search
    }

})