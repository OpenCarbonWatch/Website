<div id="footer" class="mt-5 mb-3 py-2">
    <p>
        <i>@lang('html.footer.legal', [
            'hosting' => '<a href="https://www.ovh.com/fr/support/mentions-legales/">OVH SAS</a>'
            ])</i>
    </p>
    <p>
        @lang('html.footer.contact', [
            'github' => '<a href="https://github.com/OpenCarbonWatch">GitHub</a>',
            'twitter' => '<a href="https://twitter.com/OpenCarbonWatch">Twitter</a>',
            'email' => '<a href="&#109ailt&#111;&#58;cont&#97;ct&#64;o&#112;enc&#97;&#114;&#98;onw&#97;t&#99;h&#46;o&#114;g">cont&#97;ct&#64;o&#112;enc&#97;&#114;&#98;onw&#97;t&#99;h&#46;o&#114;g</a>'
            ])
    </p>
    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
        <div class="lang">
            <a rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">{{ strtoupper($localeCode) }}</a>
        </div>
    @endforeach
</div>
