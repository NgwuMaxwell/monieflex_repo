<footer class="admin-footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 text-center">
                <p class="mb-0">
                    {{ gs()->footer_text ?? 'Developed by Maxtek Digital' }} | 
                    &copy; {{ date('Y') }} {{ gs()->footer_copyright ?? gs()->site_name }}. 
                    @lang('All rights reserved.')
                </p>
            </div>
        </div>
    </div>
</footer>

<style>
    /* Ensure html and body take full height */
    html {
        height: 100%;
    }
    
    body {
        min-height: 100%;
        display: flex;
        flex-direction: column;
    }
    
    /* Make bodywrapper__inner flexbox container */
    .bodywrapper__inner {
        display: flex;
        flex-direction: column;
        min-height: calc(100vh - 70px); /* Subtract header/nav height */
    }
    
    /* Panel content takes available space */
    .bodywrapper__inner > *:not(.admin-footer) {
        flex: 0 0 auto;
    }
    
    /* Footer styling and positioning */
    .admin-footer {
        background: #fff;
        border-top: 1px solid #e5e5e5;
        padding: 20px 0;
        margin-top: auto !important;
        font-size: 14px;
        color: #6c757d;
    }
    
    .admin-footer p {
        margin: 0;
        line-height: 1.5;
    }
    
    @media (max-width: 768px) {
        .admin-footer {
            padding: 15px 0;
            font-size: 12px;
        }
    }
</style>
