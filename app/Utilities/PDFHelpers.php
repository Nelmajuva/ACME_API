<?php

namespace App\Utilities;

use Mpdf\Mpdf;

class PDFHelpers
{
  public string $stylesheet;

  public function __construct()
  {
    $this->stylesheet = '
      <style>
        .text {
          font-size: 16px;
          font-weight: 400;
        }    

        .container {
          width: 100%;
          height: 100%;
          padding-left: 16px;
          padding-right: 16px;
          padding-top: 24px;
        }

        .table, 
        .th,
        .td,
        .tr {
          width: 100%;
          border: .5px solid #000;
          border-collapse:collapse;
        }

        .tr .td, .th, .td {
          height: 120px;
          font-size: 48px;
        }

        .td {
          padding-left: 24px;
          padding-right: 24px;
        }
      </style>
    ';
  }

  /**
   * Create a new instance.
   * 
   * @return \Mpdf\Mpdf
   */
  public function initDocument()
  {
    $mpdf = new Mpdf([
      'mode' => 'utf-8',
      'format' => 'A4',
      'margin_left' => 0,
      'margin_right' => 0,
      'margin_top' => 0,
      'margin_bottom' => 0,
      'margin_header' => 0,
      'margin_footer' => 0,
      'default_font_size' => 16,
      'default_font' => 'Montserrat',
    ]);

    return $mpdf;
  }

  /**
   * Casting \Mpdf\Mpdf to string.
   *
   * @return string
   */
  public function generateContentBlob(Mpdf $mpdf)
  {
    try {
      $pdfContent = $mpdf->Output('', \Mpdf\Output\Destination::STRING_RETURN);
      unset($mpdf);

      return $pdfContent;
    } catch (\Throwable $th) {
      throw $th;
    }
  }
}
