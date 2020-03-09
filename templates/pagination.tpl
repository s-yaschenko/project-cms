<nav>
    <ul class="pagination pagination-sm">
        {section start=1 loop=$paginator.pages+1 name="paginator"}
            <li class="page-item {if $smarty.section.paginator.iteration == $paginator.current}active{/if}">
                {if $smarty.section.paginator.iteration == $paginator.current}
                    <span class="page-link">{$smarty.section.paginator.iteration}</span>
                {else}
                    <a class="page-link" href="?page={$smarty.section.paginator.iteration}">{$smarty.section.paginator.iteration}</a>
                {/if}
            </li>
        {/section}
    </ul>
</nav>