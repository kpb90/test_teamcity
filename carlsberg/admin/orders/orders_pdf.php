<?php 
error_reporting(E_ALL);
ini_set('display_errors','off');
ob_end_clean();
require_once('../tcpdf/examples/lang/eng.php' );
require_once('../tcpdf/tcpdf.php' );
include_once "../carlsberg_function.php";
//require_once( $docRoot . 'tcpdf/htmlcolors.php' );

class OrderPdf extends TCPDF 
{
	private $style_pdf;
	private $id = '';
	private $data_for_show = '';
	public $file_to_path;
	function __construct( $data, $orientation, $unit, $format ) {
		parent::__construct( 'L', $unit, $format, true, 'UTF-8', false );
		
		$tr_str = '';
		$data['customer_id_factory'] =intval($data['customer_id_factory']);
		if ($data['customer_id_factory'] == ALL_FACTORY) {
				$data['f_subgtitle'] = "Восток-Сервис";
		} else if ($data['customer_id_factory'] == HEADQUARTERS) {
			$data['f_subgtitle'] = "Штаб квартира carlsberg";
		}
		
		$text_order = '<table'.$this->GetBetween($data['text_order'],'<table','</table>').'</table>';
		$text_order = preg_replace("/<([a-z][a-z0-9]*)[^>]*?(\/?)>/i",'<$1$2>', $text_order);

		$text_order = str_replace (array('<td>', '</td>', '<a','</a>','<td><br/><br/><br/><br/>','<br/><br/><br/></td>','<div>','</div>'),
								   array("<td><br/><br/>", '<br/><br/></td>', '<div','</div>', "<td><br/><br/>","<br/><br/></td>",'',''),  $text_order);
		//var_dump($text_order);
		$this->data_for_show = "
		<div class = 'info'>
			<div>Заявка №{$data['id']} </div>
			".($data['f_gtitle'] ? "<div>Завод: {$data['f_gtitle']}</div>":'')."
			".($data['f_subgtitle'] ? "<div>Подразделение: {$data['f_subgtitle']}</div>":'')."
			".($data['manager_name'] ? "<div>ФИО ответственного: {$data['manager_name']}</div>":'')."
		</div>
		<br><br><br><br>".'
		'.$text_order;
		$data_OM_store = array (ORDER_REJECTED => 'отклонена', ORDER_APPROVED =>'одобрена');
		$this->data_for_show .= "<br/><br/><br/><br/><br/><br/>";
		if(isset($data_OM_store[$data['status_OM_id']])) {
			$this->data_for_show .= "<div>Заявка {$data_OM_store[$data['status_OM_id']]}"; ;
		}
		$this->data_for_show .= "&nbsp;&nbsp;&nbsp;{$data['manager_name']}, ".date('d.m.Y')."</div>";

		$this->id = $data['id'];
		$this->style_pdf = $this->get_style ();
		# Set the page margins: 72pt on each side, 36pt on top/bottom.
		//$this->SetMargins( 72, 10, 72, true );
		$this->SetAutoPageBreak( true, 36 );

		# Set document meta-information
		$this->SetCreator( PDF_CREATOR );
		$this->SetAuthor( 'Order (http://vostok.spb.ru/carlsberg/)' );
		//$this->SetTitle( 'Счет фактура для ' . $this->invoiceData['user'] );
		$this->SetSubject( "Заявка" );
		$this->SetKeywords( 'Заявка' );

		//set image scale factor
		$this->setImageScale(PDF_IMAGE_SCALE_RATIO);

		//set some language-dependent strings
		global $l;
		$this->setLanguageArray($l);
	}

	private function get_style ()
	{ 
		return 
		'
			<style>
				.info {
					font-size:11px;
				}

				table {
					border-collapse: collapse;
					border-spacing: 0;
				}

				td {
					border: 1px solid black;
					text-align:center;
					font-size:11px;
					vertical-align:middle;
				}

			</style>';
	}
	
	public function create ()
	{		
		$this->setPrintHeader(false);
		$this->addPage( 'L', 'LETTER' );
		$fontname = $this->addTTFfont('fonts/arial.ttf', 'TrueTypeUnicode', '', 96);
		$this->SetFont( $fontname, '', 8 );
		//$output = $this->style_pdf.$this->title_and_color.$this->style_pdf.$this->table_with_items;
		$this->writeHTML('<div>'.$this->style_pdf.$this->data_for_show.'</div>', true, 0, true, 0);

		//addToLogPDF($output);
		$this->file_to_path = "PDF_FILES/".$this->id.".pdf";
		$temp = $this->file_to_path;
		$this->Output( $this->file_to_path, 'F' );
		return $temp;
	}

	public function GetBetween($content,$start,$end){
	    $r = explode($start, $content);
	    if (isset($r[1])){
	        $r = explode($end, $r[1]);
	        return $r[0];
	    }
	    return '';
	}
}

function addToLogPDF($message,$file='log.html')
{
	if (!$message)
	{
		file_put_contents($file, '');
		return;
	}
	$handle = fopen($file, "a+");
	fwrite($handle, $message . PHP_EOL);
	fclose($handle);
}
?>