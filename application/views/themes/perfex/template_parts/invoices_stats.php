<?php defined('BASEPATH') or exit('No direct script access allowed');

$where_total = 'clientid=' . get_client_user_id() . ' AND status !=5';
if (get_option('exclude_invoice_from_client_area_with_draft_status') == 1) {
    $where_total .= ' AND status != 6';
}

$total_invoices = total_rows(db_prefix() . 'invoices', $where_total);
$total_open = total_rows(db_prefix() . 'invoices', ['status' => 1, 'clientid' => get_client_user_id()]);
$total_paid = total_rows(db_prefix() . 'invoices', ['status' => 2, 'clientid' => get_client_user_id()]);
$total_not_paid_completely = total_rows(db_prefix() . 'invoices', ['status' => 3, 'clientid' => get_client_user_id()]);
$total_overdue = total_rows(db_prefix() . 'invoices', ['status' => 4, 'clientid' => get_client_user_id()]);

$percent_open = ($total_invoices > 0 ? number_format(($total_open * 100) / $total_invoices, 2) : 0);
$percent_paid = ($total_invoices > 0 ? number_format(($total_paid * 100) / $total_invoices, 2) : 0);
$percent_overdue = ($total_invoices > 0 ? number_format(($total_overdue * 100) / $total_invoices, 2) : 0);
$percent_not_paid_completely = ($total_invoices > 0 ? number_format(($total_not_paid_completely * 100) / $total_invoices, 2) : 0);

?>
<div class="col-md-12 invoice-quick-info invoices-stats tw-mb-10">
    <div class="row">
        <div class="col-xs-12 col-md-6 col-sm-6 col-lg-3 tw-mb-2 sm:tw-mb-0">              
            <div class="top_stats_wrapper">                                  
                <div class="tw-text-neutral-800 mtop5 tw-flex tw-items-center tw-justify-between">                      
                    <div class="tw-font-medium tw-inline-flex text-neutral-600 tw-items-center tw-truncate">                          
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="tw-w-6 tw-h-6 tw-mr-3 rtl:tw-ml-3 tw-text-neutral-600">                              <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"></path>                          </svg>                          
                        <span class="tw-truncate"><?= _l('invoices_awaiting_payment'); ?></span>                      
                    </div>                      
                    <span class="tw-font-semibold tw-text-neutral-600 tw-shrink-0">
                        <?= e($total_open); ?> /
                        <?= e($total_invoices); ?>
                    </span> 
                </div>                    
                <div class="progress tw-mb-0 tw-mt-4">                      
                    <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="40" aria-valuemin="0"
                        aria-valuemax="100" style="width: 0%" data-percent="<?= e($percent_open); ?>">
                    </div>                 
                </div>              
            </div>          
        </div>
        <div class="col-xs-12 col-md-6 col-sm-6 col-lg-3 tw-mb-2 sm:tw-mb-0">              
            <div class="top_stats_wrapper">                                  
                <div class="tw-text-neutral-800 mtop5 tw-flex tw-items-center tw-justify-between">                      
                    <div class="tw-font-medium tw-inline-flex text-neutral-600 tw-items-center tw-truncate">                          
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="tw-w-6 tw-h-6 tw-mr-3 rtl:tw-ml-3 tw-text-neutral-600">                              <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"></path>                          </svg>                          
                        <span class="tw-truncate"><?= _l('invoice_status_paid'); ?></span>                      
                    </div>                      
                    <span class="tw-font-semibold tw-text-neutral-600 tw-shrink-0">
                        <?= e($total_paid); ?> /
                        <?= e($total_invoices); ?>
                    </span> 
                </div>                    
                <div class="progress tw-mb-0 tw-mt-4">                      
                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0"
                        aria-valuemax="100" style="width: 0%" data-percent="<?= e($percent_paid); ?>">
                    </div>                 
                </div>              
            </div>          
        </div>
        <div class="col-xs-12 col-md-6 col-sm-6 col-lg-3 tw-mb-2 sm:tw-mb-0">              
            <div class="top_stats_wrapper">                                  
                <div class="tw-text-neutral-800 mtop5 tw-flex tw-items-center tw-justify-between">                      
                    <div class="tw-font-medium tw-inline-flex text-neutral-600 tw-items-center tw-truncate">                          
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="tw-w-6 tw-h-6 tw-mr-3 rtl:tw-ml-3 tw-text-neutral-600">                              <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"></path>                          </svg>                          
                        <span class="tw-truncate"><?= _l('invoice_status_overdue'); ?></span>                      
                    </div>                      
                    <span class="tw-font-semibold tw-text-neutral-600 tw-shrink-0">
                        <?= e($total_overdue); ?> /
                        <?= e($total_invoices); ?>
                    </span> 
                </div>                    
                <div class="progress tw-mb-0 tw-mt-4">                      
                    <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="40" aria-valuemin="0"
                        aria-valuemax="100" style="width: 0%" data-percent="<?= e($percent_overdue); ?>">
                    </div>                 
                </div>              
            </div>          
        </div>
        <div class="col-xs-12 col-md-6 col-sm-6 col-lg-3 tw-mb-2 sm:tw-mb-0">              
            <div class="top_stats_wrapper">                                  
                <div class="tw-text-neutral-800 mtop5 tw-flex tw-items-center tw-justify-between">                      
                    <div class="tw-font-medium tw-inline-flex text-neutral-600 tw-items-center tw-truncate">                          
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="tw-w-6 tw-h-6 tw-mr-3 rtl:tw-ml-3 tw-text-neutral-600">                              <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"></path>                          </svg>                          
                        <span class="tw-truncate"><?= _l('invoice_status_not_paid_completely'); ?></span>                      
                    </div>                      
                    <span class="tw-font-semibold tw-text-neutral-600 tw-shrink-0">
                        <?= e($total_not_paid_completely); ?> /
                        <?= e($total_invoices); ?>
                    </span> 
                </div>                    
                <div class="progress tw-mb-0 tw-mt-4">                      
                    <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="40" aria-valuemin="0"
                        aria-valuemax="100" style="width: 0%" data-percent="<?= e($percent_not_paid_completely); ?>">
                    </div>                 
                </div>              
            </div>          
        </div>
    </div>
</div>