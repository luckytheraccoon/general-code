<div class="container">
    <div class="row">
        <ul class="page__breadcrumb {if $invertColors}invert-color{/if}">
            <li class="page__breadcrumb--item">
                <a href="/">Home</a>
            </li>
            {if isset($secondCrumb)}
            <li aria-hidden="true" class="page__breadcrumb--item">
                <i class="fa fa-chevron-right"></i>
            </li>
            <li class="page__breadcrumb--item">
                {if isset($secondCrumbUrl)}
                    <a href="{$secondCrumbUrl}">{$secondCrumb}</a>
                {else}
                    <span>{$secondCrumb}</span>
                {/if}
            </li>
            {/if}
            {if isset($thirdCrumb)}
            <li aria-hidden="true" class="page__breadcrumb--item">
                <i class="fa fa-chevron-right"></i>
            </li>
            <li class="page__breadcrumb--item">
                <span>{$thirdCrumb}</span>
            </li>
            {/if}
        </ul>
    </div>
</div>