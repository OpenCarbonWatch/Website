<template>
    <div class="form-group">
        <label for="activity">{{ lang('activity') }}</label>
        (<a href="https://www.insee.fr/fr/metadonnees/nafr2/section/A">{{ lang('naf') }}</a>)
        <autocomplete :search="search" :getResultValue="getResultValue" :debounceTime=100 id="activity">
            <template #result="{ result, props }">
                <li v-bind="props" class="autocomplete-result">
                    <span class="badge badge-light">{{ lang('level') + ' ' + result.level }}</span>
                    <span :style="'padding-left:' + (result.level * 10) + 'px;'">{{ result.label }}</span>
                </li>
            </template>
        </autocomplete>
    </div>
</template>

<script>
    const MIN_LENGTH = 1;
    const TRANSLATIONS = {
        'en': {
            'activity': 'Main activity',
            'level': 'Level',
            'naf': 'NAF code',
        },
        'fr': {
            'activity': 'Activité principale (code NAF)',
            'level': 'Niveau',
            'naf': 'code NAF',
        },
    };
    export default {
        methods: {
            lang(key) {
                return TRANSLATIONS[document.documentElement.lang][key];
            },
            getResultValue(result) {
                return result.label;
            },
            search: async function (value) {
                if (value.length >= MIN_LENGTH) {
                    return $.ajax({
                        url: '/france/search/data/activity/' + encodeURIComponent(value),
                        type: 'GET',
                        data: {},
                    });
                } else {
                    return [];
                }
            },
        },
    }
</script>
