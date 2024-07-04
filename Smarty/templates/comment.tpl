<div class="card p-2 mt-2">
    <div class="d-flex justify-content-between align-items-start">
        <div class="user d-flex flex-column">
            <span>
                <small class="fw-bold text-primary">{$comment->getCommentUsername()}</small>
            </span>
            <span class="comment-text">
                <small class="fw-bold">{$comment->getCommentText()}</small>
            </span>
            <small class="ml-auto">{$comment->getCommentTime()}</small>
        </div>
        <div class="reply px-0">
            <a href="#" class="btn btn-outline-success reply">Reply</a>
        </div>
    </div>
</div>
{if $replies|@count > 0}
    <div class="replies ml-4 mt-2">
        {foreach from=$replies item=reply}
            {include file='comment.tpl' comment=$reply.0 replies=$reply.1}
        {/foreach}
    </div>
{/if}
