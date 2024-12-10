<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// Einbindung von REST_Controller
require __DIR__ . '/REST_Controller.php';

class Calls extends REST_Controller {
    public function __construct() {
        // Konstruktor des Elternteils aufrufen
        parent::__construct();
        $this->load->model('Calls_model');
    }

    /**
     * @api {post} api/v1/calls Handle call operation
     * @apiName HandleCall
     * @apiGroup Calls
     *
     * @apiHeader {String} Authorization Basic Access Authentication token.
     *
     * @apiParam {String} operation The type of operation (new, update, etc.).
     * @apiParam {Object} call The call details (uid, direction, duration, etc.).
     *
     * @apiSuccess {Boolean} success Request status.
     * @apiSuccess {String} message Operation result message.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "success": true,
     *       "message": "Call logged successfully."
     *     }
     *
     * @apiError {Boolean} success Request status.
     * @apiError {String} message Error message.
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 400 Bad Request
     *     {
     *       "success": false,
     *       "message": "Invalid parameters."
     *     }
     */
    public function index_post() {
        // Eingaben aus dem Request abrufen
        $operation = $this->input->post('operation');
        $callParams = $this->input->post('call');

        if (!$operation || !$callParams) {
            $this->response(['success' => false, 'message' => 'Invalid parameters'], REST_Controller::HTTP_BAD_REQUEST);
            return;
        }

        // Operation ausführen
        if ($operation === 'new') {
            $this->Calls_model->log_call($callParams);
            $this->response(['success' => true, 'message' => 'Call logged successfully'], REST_Controller::HTTP_OK);
        } else {
            $this->response(['success' => false, 'message' => 'Unsupported operation'], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}
