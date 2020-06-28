<template>
    <div class="form-group">
        <autocomplete :search="search" :getResultValue="getResultValue" :debounceTime=100 id="geography">
            <template #result="{ result, props }">
                <li v-bind="props" class="autocomplete-result">
                    {{ result.label }}
                    <span v-if="result.class==='region'" class="badge badge-warning">{{ lang('region') }}</span>
                    <span v-if="result.class==='department'" class="badge badge-light">{{ lang('department') }}</span>
                    <span v-if="result.class==='city'" class="badge badge-info">{{ result.badge }}</span>
                </li>
            </template>
            <template #label>
                {{ lang('geography') }}
            </template>
        </autocomplete>
    </div>
</template>

<script>
    import Autocomplete from "./Autocomplete";
    const MIN_LENGTH = 3;
    const TRANSLATIONS = {
        'en': {
            'department': 'Department',
            'geography': 'Headquarters region, department or city',
            'region': 'Region',
        },
        'fr': {
            'department': 'Département',
            'geography': 'Région, département ou commune du siège',
            'region': 'Région',
        },
    };
    export default {
        components: {Autocomplete},
        methods: {
            lang(key) {
                return TRANSLATIONS[document.documentElement.lang][key];
            },
            getResultValue(result) {
                return result.label;
            },
            search: async function (value) {
                if (value.length >= MIN_LENGTH) {
                    return (await axios.get('/france/search/data/geography/' + encodeURIComponent(value))).data;
                } else {
                    return [];
                }
            },
        },
    }
</script>
