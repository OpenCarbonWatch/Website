<template>
    <div class="form-group">
        <autocomplete :search="search" :getResultValue="getResultValue" :debounceTime=100 id="activity">
            <template #result="{ result, props }">
                <li v-bind="props" class="autocomplete-result">
                    <span class="badge badge-light">{{ lang('level') + ' ' + result.level }}</span>
                    <span :style="'padding-left:' + (result.level * 10) + 'px;'">{{ result.label }}</span>
                </li>
            </template>
            <template #label>
                {{ lang('activity') }}
                (<a href="https://www.insee.fr/fr/metadonnees/nafr2/section/A">{{ lang('naf') }}</a>)
            </template>
        </autocomplete>
    </div>
</template>

<script>
    import Autocomplete from "./Autocomplete";
    const MIN_LENGTH = 2;
    const TRANSLATIONS = {
        'en': {
            'activity': 'Main activity',
            'level': 'Level',
            'naf': 'NAF codes list',
        },
        'fr': {
            'activity': 'Activité principale',
            'level': 'Niveau',
            'naf': 'liste des codes NAF',
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
                    const response = await fetch('/france/search/data/activity/' + encodeURIComponent(value));
                    return response.json();
                } else {
                    return [];
                }
            },
        },
    }
</script>
