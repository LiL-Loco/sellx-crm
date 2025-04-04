<?php

defined('BASEPATH') || exit('No direct script access allowed');

include_once APPPATH.'/libraries/pdf/App_pdf.php';

class Contract_pdf extends App_pdf
{
    protected $contract;
    protected $is_ending_page = false;

    protected $page_width;
    protected $page_height;

    protected $render_cover_page = false;

    public function __construct($contract)
    {
        $this->load_language($contract->client);

        $contract                = hooks()->apply_filters('contract_html_pdf_data', $contract);
        $GLOBALS['contract_pdf'] = $contract;

        parent::__construct();

        $this->contract = $contract;

        $this->page_width  = $this->getPageDimensions()['wk'];
        $this->page_height = $this->getPageDimensions()['hk'];

        $this->SetTitle($this->contract->subject);

        # Don't remove these lines - important for the PDF layout
        $this->contract->content = $this->fix_editor_html($this->contract->content ?? '');

        // Add Cover page
        $this->getCoverPage();
    }

    public function prepare()
    {
        $this->set_view_vars('contract', $this->contract);

        return $this->build();
    }

    // Page header
    public function Header()
    {
        if (($this->render_cover_page == false && $this->page > 1) || $this->is_ending_page == false) {
            $header_text = getPdfOptions('contract', 'header', 'text');

            $pdf_header_image = getPdfOptions('contract', 'header', 'image');
            $image_url        = base_url('uploads/custom_pdf/contract/'.$pdf_header_image);

            $this->Image($image_url, 0, 0, $this->getPageDimensions()['wk'], 30);
            $this->writeHTMLCell(0, 0, 10, 12, $header_text, 0, 0, 0, true, '', true);

            $this->SetTopMargin(15);
        }
    }

    // Page footer
    public function Footer()
    {
        if ($this->render_cover_page === false && $this->is_ending_page === false || ($this->page > 1 && $this->is_ending_page === false)) {
            $footer_text = getPdfOptions('contract', 'footer', 'text');

            $pdf_footer_image = getPdfOptions('contract', 'footer', 'image');
            $image_url        = base_url('uploads/custom_pdf/contract/'.$pdf_footer_image);

            $this->Image($image_url, 0, $this->page_height - 30, $this->page_width, 30);
            $this->writeHTMLCell(0, 0, 10, -42, $footer_text, 0, 0, 0, true, '', true);

            $this->SetFooterMargin(90);
        }
    }

    // Closing page
    public function Close()
    {
        if (hooks()->apply_filters('process_pdf_signature_on_close', true)) {
            $this->processSignature();
        }

        hooks()->do_action('pdf_close', ['pdf_instance' => $this, 'type' => $this->type()]);

        $this->last_page_flag = true;

        if (!empty(getPdfOptions('contract', 'closing_page', 'image')) || !empty(getPdfOptions('contract', 'closing_page', 'text'))) {
            $this->AddPage();
            $this->is_ending_page = true;
            $bMargin              = $this->getBreakMargin();
            $auto_page_break      = $this->getAutoPageBreak();
            $this->SetAutoPageBreak(false, 0);

            $pdf_cover_image = getPdfOptions('contract', 'closing_page', 'image');
            $close_page_text = getPdfOptions('contract', 'closing_page', 'text');

            $parsedClosePageText = parsePDFMergeFields('contract', $close_page_text, $this->contract);
            $align_from_left     = getPdfOptions('contract', 'closing_page', 'align_from_left');
            $align_from_top      = getPdfOptions('contract', 'closing_page', 'align_from_top');
            $img_file            = base_url('uploads/custom_pdf/contract/'.$pdf_cover_image);

            $this->Image($img_file, 0, 0, $this->page_width, $this->page_height, '', '', '', false, 300, '', false, false, 0);
            $this->writeHTMLCell(0, 0, $align_from_left, $align_from_top, $parsedClosePageText, 0, 0, 0, true, '', true);

            $this->SetAutoPageBreak($auto_page_break, $bMargin);
            $this->setPageMark();
        }

        TCPDF::Close();
    }

    protected function type()
    {
        return 'contract';
    }

    // Cover page
    protected function getCoverPage()
    {
        if (!empty(getPdfOptions('contract', 'cover_page', 'image')) || !empty(getPdfOptions('contract', 'cover_page', 'text'))) {
            $this->render_cover_page = true;
            $bMargin         = $this->getBreakMargin();
            $auto_page_break = $this->getAutoPageBreak();
            $this->SetAutoPageBreak(false, 0);

            $pdf_cover_image = getPdfOptions('contract', 'cover_page', 'image');
            $cover_page_text = getPdfOptions('contract', 'cover_page', 'text');

            $parsedCoverPageText = parsePDFMergeFields('contract', $cover_page_text, $this->contract);

            $align_from_left = getPdfOptions('contract', 'cover_page', 'align_from_left');
            $align_from_top  = getPdfOptions('contract', 'cover_page', 'align_from_top');

            $img_file = base_url('uploads/custom_pdf/contract/'.$pdf_cover_image);

            $this->Image($img_file, 0, 0, $this->page_width, $this->page_height, '', '', '', false, 300, '', false, false, 0);
            $this->writeHTMLCell(0, 0, $align_from_left, $align_from_top, $parsedCoverPageText, 0, 0, 0, true, '', true);

            // restore auto-page-break status
            $this->SetAutoPageBreak($auto_page_break, $bMargin);
            // set the starting point for the page content
            $this->setPageMark();

            $this->AddPage();
        }
    }

    protected function file_path()
    {
        $customPath = APPPATH.'views/themes/'.active_clients_theme().'/views/my_contractpdf.php';
        $actualPath = APPPATH.'views/themes/'.active_clients_theme().'/views/contractpdf.php';

        if (file_exists($customPath)) {
            $actualPath = $customPath;
        }

        return $actualPath;
    }
}
