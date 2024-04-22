<script setup>
import {useRoute} from 'vue-router'
import Roles from '../../../views/Roles/allRolesList.vue'
const route = useRoute()
const activeTab = ref(route.params.tab)

// tabs
const tabs = [
    {
        title: 'All',
        icon: 'fa-tasks',
        tab: 'all',
    },
    {
        title: 'Active',
        icon: 'bx-lock-open',
        tab: 'active',
    },
    {
        title: 'Inactive',
        icon: 'bx-lock',
        tab: 'inactive',
    },
]
</script>
<template>
    <div>
        <VTabs
            v-model="activeTab"
            show-arrows
        >
            <VTab
                v-for="item in tabs"
                :key="item.icon"
                :value="item.tab"
            >
                <VIcon
                    size="20"
                    start
                    :icon="item.icon"
                />
                {{ item.title }}
            </VTab>
        </VTabs>
        <VDivider/>

        <VWindow
            v-model="activeTab"
            class="mt-5 disable-tab-transition"
        >
            <!-- All -->
            <VWindowItem value="all">
                <Roles :item="{status: -1}"/>
            </VWindowItem>

            <!-- Active -->
            <VWindowItem value="active">
                <Roles :item="{status: 1}"/>
            </VWindowItem>

            <!-- Inactive -->
            <VWindowItem value="inactive">
                <Roles :item="{status: 0}"/>
            </VWindowItem>
        </VWindow>
    </div>
</template>
