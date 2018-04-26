<ul class="col right padding-8 margin-0">
    {foreach item=item key=key from=$data}
        <li class="right">
            <a href="{$item.link}" class="color-text-gray font-medium padding-medium padding-16 upper color-hover-gray-light transition-easy">{$item.titulo}</a>
        </li>
    {/foreach}
</ul>