<?php

namespace App\Component;

/**
 * Klasa generująca dokumenty na podstawie szablonów w postaci plików DOCX
 * @author Wiktor Henc
 */
class Docxgen
{
    /**
     * Flaga określająca pracę w trybie debug. Ustawiana w konstruktorze za pomocą trzeciego argumentu - domyślnie FALSE
     * W tym trybie znaczniki w szablonie dla nieistniejącyc zmiennych zostaną zamienione na ciąg: "[undefined field: nazwa_zmiennej]"
     * @var boolean
     */
    private $debugMode;

    /**
     *
     * @var string ścieżka do szablonu
     */
    private $template;

    /**
     *
     * @var string dwuznakowy znacznik zmiennych w szablonie
     */
    private $delimiter = '{}';

    /**
     *
     * @var string
     */
    private $cleanRegExp = '(\s*\<(["=*\w+\:\/\d+\\\\]*)\>\s*)*';
    //private $cleanRegExp = '(\s*\<(["=-\s*\w+\:\/\d+\\\\]*)\>\s*)*';

    /**
     * Folder, w którym zostaną rozpakowane szablony. Domyślnie: sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'Docxgen_temp' . DIRECTORY_SEPARATOR . uniqid()
     * @var string
     */
    private $tmpDir;

    /**
     * Ścieżka do tymczasowego wydruku
     * @var string
     */
    private $tmpFilePath;

    /**
     *
     * @var string
     */
    private $password;

    /**
     *
     * @var array tablica asocjacyjna ze zmiennymi
     */
    private $assigned_field = array();

    /**
     *
     * @var array tablica asocjacyjna ze zmiennymi blokowymi(listy)
     */
    private $assigned_block = array();

    /**
     * Ostatni "wolny" identyfikator elementu z plików zależności .rels
     * @var int
     */
    private $lasRelsId = 1;

    /**
     *
     * @var array tablica asocjacyjna zawierająca informacje o plikach graficznych w postaci 'ścieżka do pliku' => 'id z pliku zależności .rels'
     */
    private $images = array();

    /**
     * Tablica przechowująca rozszerzenia plików graficznych wstawionych do wydruku
     * @var array
     */
    private $imageExtensions = array();

    /**
     * "Szablon" grafiki
     * @var string
     */
    private $imageTemplate = '<w:drawing>
					<wp:inline distT="0" distB="0" distL="0" distR="0">
						<wp:extent cx="[x]" cy="[y]"/>
						<wp:effectExtent l="0" t="0" r="0" b="0"/>
						<wp:docPr id="[id]" name="Obraz [id]" descr="rId[id]"/>
						<wp:cNvGraphicFramePr>
							<a:graphicFrameLocks xmlns:a="http://schemas.openxmlformats.org/drawingml/2006/main" noChangeAspect="1"/>
						</wp:cNvGraphicFramePr>
						<a:graphic xmlns:a="http://schemas.openxmlformats.org/drawingml/2006/main">
							<a:graphicData uri="http://schemas.openxmlformats.org/drawingml/2006/picture">
								<pic:pic xmlns:pic="http://schemas.openxmlformats.org/drawingml/2006/picture">
									<pic:nvPicPr>
										<pic:cNvPr id="[id]" name="rId[id]"/>
										<pic:cNvPicPr/>
									</pic:nvPicPr>
									<pic:blipFill>
										<a:blip r:embed="rId[id]" cstate="print"/>
										<a:stretch>
											<a:fillRect/>
										</a:stretch>
									</pic:blipFill>
									<pic:spPr bwMode="auto">
										<a:xfrm>
											<a:off x="0" y="0"/>
											<a:ext cx="[x]" cy="[y]"/>
										</a:xfrm>
										<a:prstGeom prst="rect">
											<a:avLst/>
										</a:prstGeom>
									</pic:spPr>
								</pic:pic>
							</a:graphicData>
						</a:graphic>
				</wp:inline>
			</w:drawing>';

    /**
     * Tablica przechowująca nazwy składowych wydruku (np. document.xml, header.xml, footer.xml itd.)
     * @var array
     */
    private $additionalRels = array();

    /**
     * "Pusty szablon" pliku zależności
     * @var string
     */
    private $relsTemplate = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships"></Relationships>';

    /**
     * Metoda tworząca obiekt.
     * Domyślnie katalogiem tymczasowym będzie: sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'Docxgen_temp' . DIRECTORY_SEPARATOR . uniqid().
     * Opcjonalnie można go zmienić za pomocą metody setTempDirectory($tempDirectory)f
     * @param string $template ścieżka do szablonu
     * @param boolean $debugMode flaga włączająca tryb debugowania - niezdefiniowane zmienne zostaną widocznie oznaczone na wydruku: [undefined field/block nazwa_zmiennej].
     * Dodatkowo pliki tymczasowe nie będą usuwane z katalogu tymczasowego
     * @throws Exception
     */
    public function __construct($template = NULL, $debugMode = FALSE) {
        if (is_null($template) == FALSE) {
            $this->setTemplate($template);
        }
        $this->debugMode = $debugMode;
        $this->uniqid = uniqid();
        if (($docxTempDirectory = ini_get('upload_tmp_dir'))) {
            $this->tmpDir = $docxTempDirectory . DIRECTORY_SEPARATOR . 'Docxgen_temp' . DIRECTORY_SEPARATOR . $this->uniqid;
        } else {
            $this->tmpDir = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'Docxgen_temp' . DIRECTORY_SEPARATOR . $this->uniqid;
        }
        $this->tmpFilePath = $this->tmpDir . DIRECTORY_SEPARATOR . $this->uniqid . '.docx';
    }

    public function setTemplate($template) {
        if (is_readable($template)) {
            $this->template = $template;
        } else {
            throw new \Exception(__METHOD__ . '((' . gettype($template) . ')' . (string) $template . '): template was not found![' . __FILE__ . '][line:' . __LINE__ . ']');
        }
    }

    /**
     * Metoda pozwalająca nadpisać katalog tymczasowy.
     * W trakcie pracy, skrypt utworzy następujący katalog: $tempDirectory . DIRECTORY_SEPARATOR . uniqid().
     * Domyślnie tworzony jest katalog: sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'Docxgen_temp' . DIRECTORY_SEPARATOR . uniqid().
     * @param string $tempDirectory ścieżka do katalogu, bez kończącego znaku DIRECTORY_SEPARATOR
     * @throws \Exception
     */
    public function setTempDirectory($tempDirectory) {
        if (strlen(trim((string) $tempDirectory)) > 0) {
            $this->tmpDir = $tempDirectory . DIRECTORY_SEPARATOR . $this->uniqid;
            $this->tmpFilePath = $this->tmpDir . DIRECTORY_SEPARATOR . $this->uniqid . '.docx';
        } else {
            throw new \Exception(__METHOD__ . '((' . gettype($tempDirectory) . ')' . (string) $tempDirectory . '): invalid temp directory![' . __FILE__ . '][line:' . __LINE__ . ']');
        }
    }

    /**
     * Metoda pozwala na zmianę domyślnego delimitera '{}'
     * @param string $delimiter
     * @throws \Exception
     */
    public function setDelimiter($delimiter) {
        if (is_string($delimiter) == TRUE && strlen($delimiter) == 2) {
            $this->delimiter = $delimiter;
        } else {
            throw new \Exception('Delimiter must be a 2 char string!');
        }
    }

    /**
     * Metoda służy przekazaniu tablicy danych do wydruku
     * @param array $data
     * @return boolean TRUE w przypadku poprawnego przyjęcia danych, FALSE w p. p.
     */
    public function setData($data) {
        if (is_array($data) == TRUE) {
            foreach ($data as $key => &$value) {
                if (is_array($value) == TRUE) {
                    $this->assigned_block[$key] = $value;
                } else {
                    $this->assigned_field[$key] = $value;
                }
            }
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Metoda pozwala zablokować edycję dokumentu. Zdjęcie blokady będzie wymagać podania hasła.
     * @param string $password
     * @todo Metoda poprawnie blokuje dokument jednak jeszcze nie ma możliwości zdjęcia blokady. Trwają "ataki" na poprawne wykonanie hash'a.
     */
    public function setPassword($password = NULL) {
        $this->password = (string) $password;
    }

    /**
     * Metoda zwraca wygenerowany wydruk do przeglądarki
     * @param string $name nazwa zwracanego pliku, domyślnie nazwa pliku tymczasowego
     */
    public function download($name = NULL) {
        if (is_null($name)) {
            $name = basename($this->tmpFilePath);
        }
        $this->generate();
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $name . '"');
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($this->tmpFilePath));
        readfile($this->tmpFilePath);
        exit;
    }

    /**
     * Metoda generuje dokument
     */
    public function generate() {
        if (isset($this->template) == FALSE) {
            throw new \Exception(__METHOD__ . ': template is undefined! Use setTemplate($template) function.[' . __FILE__ . '][line:' . __LINE__ . ']');
        }
        $this->save($this->tmpFilePath);
    }

    /**
     * Metoda zwraca zawartość wygenerowanego dokumentu
     * @return string
     */
    public function getContent() {
        $this->generate();
        return file_get_contents($this->tmpFilePath);
    }

    /**
     * Metoda zwaraca ścieżkę do pliku generowanego wydruku
     * @return string
     */
    public function getPath() {
        return $this->tmpFilePath;
    }

    /**
     * Główna metoda generująca wydruk
     * @param string $outputFile pełna ścieżka zapisu gotowego wydruku
     */
    private function save($outputFile) {
        //Rozpakuj szablon
        $this->extract();
        //Znajdź ostatni wolny rId z plików zależności
        $relationships = file_get_contents($this->tmpDir . '/word/_rels/document.xml.rels');
        $matches = array();
        preg_match_all('/Id=\"rId(.*?)\"/', $relationships, $matches);
        sort($matches[1]);
        $this->lasRelsId = ((int) end($matches[1])) + 1;
        unset($matches);
        //Zapisz poszczególne elementy wydruku
        $this->saveElement('document');
        $this->saveElement('header');
        $this->saveElement('footer');
        //Zaktualizuj pliki zależności
        $this->updateRels();
        //Ustaw hasło
        if (isset($this->password) == TRUE) {
            $this->savePassword();
        }
        //Spakuj wydruk
        $this->compact($outputFile);
        if ($this->debugMode == FALSE) {
            register_shutdown_function(array($this, 'cleanTemp'), realpath($this->tmpDir));
        }
    }

    /**
     * Metoda generuje i zapisuje elementy wydruku o wskazanej nazwie (np. document, header, footer itp)
     * @param string $elementName
     */
    private function saveElement($elementName) {
        foreach ($this->getFilesStartingWith($elementName) as $file) {
            $filePath = $this->tmpDir . '/word/' . $file;
            $content = file_get_contents($filePath);
            $content = $this->cleanAndClear($content);
            if ($elementName == 'document') {
                $content = $this->parseBlocks($content);
                $content = $this->parseFields($content);
            } else {
                $matches = array();
                preg_match_all('/\[start (\w+)\].*?\[end \1\]/is', $content, $matches);
                $content = $this->parseBlocks($content, $matches[1]);
                preg_match_all('/' . $this->delimiter[0] . '(\w+)' . $this->delimiter[1] . '/si', $content, $matches);
                $content = $this->parseFields($content, $matches[1]);
                unset($matches);
            }
            $content = $this->parseIf($content);
            $content = $this->clearUndefinedFields($content);
            $this->additionalRels[] = $this->tmpDir . '/word/_rels/' . $file . '.rels';
            file_put_contents($filePath, $content);
        }
    }

    /**
     * Metoda dokonuje blokady edycji dokumentu za pomocą hasła.
     *
     * @todo hasło nie jest poprawnie hash'owane dlatego blokada nie jest jeszcze możliwa
     */
    private function savePassword() {
        $salt = 'm8HQZEiZeOOMoo+Y/2bncg==';
        $hash = 'jRjOqq9IOsZg5WwwEA9IAh2byYo='; //armando
        $filePath = $this->tmpDir . '/word/settings.xml';
        $content = file_get_contents($filePath);
        $content = str_replace('</w:settings>', '<w:documentProtection w:edit="readOnly" w:enforcement="1" w:cryptProviderType="rsaFull" w:cryptAlgorithmClass="hash" w:cryptAlgorithmType="typeAny" w:cryptAlgorithmSid="4" w:cryptSpinCount="100000" w:hash="' . $hash . '" w:salt="' . $salt . '"/></w:settings>', $content);
        file_put_contents($filePath, $content);
    }

    /**
     * Metoda wykonuje aktualizację plików zależności dla wszystkich elementów
     * dokumentu. Dodatkowo plik [Content_Types].xml uzupełniany  jest o rozszerzenia
     * zastosowanych grafik
     */
    private function updateRels() {
        //Odtwórz katalog z mediami
        if (!is_dir($this->tmpDir . '/word/media')) {
            mkdir($this->tmpDir . '/word/media');
        }
        //Uzupełnij pliki zależności o grafiki
        foreach ($this->additionalRels as $rel) {
            $this->updateImagesInRels($rel);
        }
        //Rozszerzenia grafik
        $styles = file_get_contents($this->tmpDir . "/[Content_Types].xml");
        //Sprawdź czy rozszerzenie nie jest już "załadowane" - grafiki budujące szablon
        $matches = array();
        preg_match_all('/\<Default Extension\=\"(\w*)\"/', $styles, $matches);
        $this->imageExtensions = array_unique($this->imageExtensions);
        //Dodaj tylko brakujące rozszerzenia
        foreach (array_diff($this->imageExtensions, $matches[1]) as $e) {
            $styles = str_ireplace('</Types>', '<Default Extension="' . $e . '" ContentType="image/' . $e . '"/></Types>', $styles);
        }
        file_put_contents($this->tmpDir . "/[Content_Types].xml", $styles);
    }

    /**
     * Metoda aktualizuje wpisy w pliku zależności danego elementu pod kątem wykorzystanej grafiki
     * @param string $fullPath ścieżka do pliku zawierającego element wydruku (np. document, header, footer itp.)
     */
    private function updateImagesInRels($fullPath) {
        if (file_exists($fullPath) == TRUE) {
            $relsContent = file_get_contents($fullPath);
        } else {
            $relsContent = $this->relsTemplate;
        }
        foreach ($this->images as $image) {
            $basename = basename($image['filePath']);
            copy($image['filePath'], $this->tmpDir . '/word/media/' . $basename);
            $relsContent = str_ireplace('</Relationships>', '<Relationship Id="rId' . $image['id'] . '" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/image" Target="media/' . $basename . '"/></Relationships>', $relsContent);
            $this->imageExtensions[] = substr(strrchr($basename, '.'), 1);
        }
        file_put_contents($fullPath, $relsContent);
    }

    /**
     * Metoda odpowiada za zapis zmiennych do wydruku
     * @param string $content
     * @param array $fields opcjonalna tablica zawierająca nazwy pól zmiennych do zapisu.
     * Gdy argument nie zostanie podany, wykorzystane zostaną wszystkie przekazane do zapisu zmienne
     * @return string
     */
    private function parseFields($content, $fields = array()) {
        if (count($fields) > 0) {
            foreach ($fields as $name) {
                $content = $this->addField($content, $name, isset($this->assigned_field[$name]) ? $this->assigned_field[$name] : NULL);
            }
        } else {
            foreach ($this->assigned_field as $name => $value) {
                $content = $this->addField($content, $name, $value);
            }
        }
        return $content;
    }

    /**
     * Metoda dokonuje wstawienia wartości zmiennych w odpowiednie pola szablonu.
     * @param string $content
     * @param string $name
     * @param mixed $value
     * @return string
     */
    private function addField($content, $name, $value = NULL) {
        if (is_null($value) == TRUE) {
            if ($this->debugMode == TRUE) {
                $value = '[undefined field ' . $name . ']';
            } else {
                $value = '<!-- undefined_field_' . $name . ' -->';
            }
        } else {
            if (strpos($name, 'img_') === 0) {
                $value = $this->resolveImage($value);
            } else {
                $value = $this->filter($value);
            }
        }
        $matches = array();
        preg_match_all('/\\' . $this->delimiter[0] . $this->cleanRegExp . '\s*' . $name . '\s*' . $this->cleanRegExp . '\\' . $this->delimiter[1] . '/s', $content, $matches);
        return str_ireplace($matches[0], $value, $content);
    }

    /**
     * Metoda przekształca zmienną zawierającą ścieżkę do pliku graficznego w "szablon" grafiki gotowy do wstawienia
     * @param string $file
     * @return string
     * @throws Exception wyjątek w przypadku gdy plik graficzny nie istnieje
     */
    private function resolveImage($file) {
        if (isset($this->images[$file]) == FALSE) {
            if (file_exists($file) == FALSE) {
                throw new \Exception(__METHOD__ . '(' . $file . '): image file not found![' . __FILE__ . '][line:' . __LINE__ . ']');
            }
            $dims = getimagesize($file);
            if (strtolower(substr(strrchr(basename($file), '.'), 1)) == 'jpg') {
                $ratio = 3043;
            } else {
                $ratio = 9525;
            }
            $this->images[$file] = array('id' => $this->lasRelsId, 'filePath' => $file, 'data' => str_replace(array('[id]', '[x]', '[y]'), array($this->lasRelsId, $dims[0] * $ratio, $dims[1] * $ratio), $this->imageTemplate));
            $this->lasRelsId++;
        }
        return $this->images[$file]['data'];
    }

    /**
     * Metoda znajdująca i podmieniająca znaczniki określające warunki
     * @param string $content
     * @param array $data tablica zawierająca zmienne rekordu w przypadku list lub całego wydruku(gdy $data = NULL)
     * @return type
     */
    private function parseIf($content, $data = NULL) {
        if (is_null($data) == TRUE) {
            $data = $this->assigned_field;
        }
        $pattern = '/\[' . $this->cleanRegExp . implode($this->cleanRegExp, str_split('IF')) . $this->cleanRegExp;
        $pattern .= '\s*(?P<name>\w+)';
        $pattern .= $this->cleanRegExp;
        $pattern .= '\s*(?P<condition>.*?)?';
        $pattern .= $this->cleanRegExp . '\]';
        $pattern .= '(?P<trueContent>.*?)';
        $pattern .= '(\[' . $this->cleanRegExp . implode($this->cleanRegExp, str_split('ELSE')) . $this->cleanRegExp . '\]';
        $pattern .= '(?P<falseContent>.*?)';
        $pattern .= ')?\[' . $this->cleanRegExp . implode($this->cleanRegExp, str_split('ENDIF')) . $this->cleanRegExp;
        $pattern .= '\s*(\k<name>.*?)';
        $pattern .= $this->cleanRegExp . '\]/is';
        $matches = array();
        preg_match_all($pattern, $content, $matches);
        $names = $matches['name'];
        if (count($matches['name']) > 0) {
            $replacments = array();
            foreach ($names as $key => &$name) {
                $condition = array_merge(array($name), explode(' ', trim(html_entity_decode($matches['condition'][$key])), 2));
                if (isset($data[$name]) == TRUE) {
                    $value = $data[$name];
                } else {
                    $value = '';
                }
                $condition[0] = '"' . addslashes($value) . '"';
                if (isset($condition[2])) {
                    $condition[2] = '"' . addslashes($condition[2]) . '"';
                }
                try {
                    $result = (bool) eval('return ' . implode(' ', $condition) . ';');
                } catch (\Exception $e) {
                    trigger_error($e->getMessage() . ' | [' . implode('][', $condition) . ']', E_USER_NOTICE);
                    $result = '';
                }
                $replacments[$key] = $this->parseIf($matches[$result == TRUE ? 'trueContent' : 'falseContent'][$key], $data);
            }
            return str_ireplace($matches[0], $replacments, $content);
        } else {
            return $content;
        }
    }

    /**
     * Metoda wybiera dane do wypełnienia list
     * @param string $content
     * @param string $blockNames nazwa listy
     * @return string
     */
    private function parseBlocks($content, $blockNames = NULL) {
        if (is_null($blockNames) == FALSE) {
            foreach ($blockNames as $blockName) {
                if (isset($this->assigned_block[$blockName]) == TRUE) {
                    $content = $this->parseBlock($content, $blockName, $this->assigned_block[$blockName]);
                } else {
                    $content = $this->parseBlock($content, $blockName);
                }
            }
        } else {
            foreach ($this->assigned_block as $blockName => $blockData) {
                $content = $this->parseBlock($content, $blockName, $blockData);
            }
        }
        return $content;
    }

    /**
     * Metoda wykonuje wstawienie rekordów list do wydruku
     * @param string $content
     * @param string $blockName nazwa listy
     * @param array $blockData tablica asocjacyjna z danymi do dyspozycji(zmienne rekordu w przypadku listy, tablica zmiennych wydruku w p. p.)
     * @return string
     * @todo zagnieżdzone listy
     */
    private function parseBlock($content, $blockName, $blockData = NULL) {
        $block_start_pos = $this->getNextPosOf('start ' . $blockName, ':p>', $content) + 3;
        $block_end_pos = $this->getPreviousPosOf('end ' . $blockName, '<w:p ', $content);
        $block_template = substr($content, $block_start_pos, $block_end_pos - $block_start_pos);
        $blocks = '';
        if ($block_start_pos > 0 && $block_end_pos > 0 && strlen($block_template) > 0 && is_null($blockData) == FALSE) {
            foreach ($blockData as $k => $row) {
                $block = $block_template;
                foreach ($row as $key => $value) {
                    if (is_array($value) == TRUE) {
                        $block = $this->parseBlock($block, $key, $value);
                    }
                }
                $block = $this->parseIf($block, $row);
                foreach ($row as $key => $value) {
                    if (is_array($value) == FALSE) {
                        $block = $this->addField($block, $key, $value);
                    }
                }
                $blocks .= '<!-- start_block ' . $blockName . ' record ' . ($k + 1) . ' -->' . $block . '<!-- end_block ' . $blockName . ' record ' . ($k + 1) . ' -->';
            }
            /*
             * Wywal całe <w:p> ze znacznikiem [start ...] aby nie zostawiać pustego wiersza.
             * Dzieje się tak w przypadku gdy "cały" szablon jest zbudowany na tabeli.
             */
            $clean_start_pos = $this->getPreviousPosOf('start ' . $blockName, '<w:p ', $content);
            $content = str_ireplace(array(substr($content, $clean_start_pos, $block_start_pos - $clean_start_pos)), array('[start ' . $blockName . ']'), $content);

            //@todo wywal <w:p> dla end tylko gdy w szablonie bloku jest tabela
            //Element <w:p> obejmujący znacznik [end ...] musi zostać, bo docx wymaga istnienia <w:p>...</w:p> przed </w:tc> - zakończenie komórki.
            if (stripos($block_template, '<w:tbl>') == FALSE) {
                $block_end_pos = $this->getPreviousPosOf('end ' . $blockName, '<w:p ', $content);
                $clean_end_pos = $this->getNextPosOf('end ' . $blockName, ':p>', $content) + 3;
                $content = str_ireplace(substr($content, $block_end_pos, $clean_end_pos - $block_end_pos), '[end ' . $blockName . ']', $content);
            }
            $content = str_ireplace(array('[start ' . $blockName . ']', $block_template, '[end ' . $blockName . ']'), array('<!-- start_block ' . $blockName . ' -->', $blocks, '<!-- end_block ' . $blockName . ' -->'), $content);
        }
        return $content;
    }

    /**
     * Metoda rozpakowująca szablon
     */
    private function extract() {
        mkdir($this->tmpDir, 0777, TRUE);
        $archive = new \PclZip($this->template);
        @$archive->extract(PCLZIP_OPT_PATH, $this->tmpDir);
    }

    /**
     * Metoda pakująca wydruk
     * @param string $output
     */
    private function compact($output) {
        $archive = new \PclZip($output);
        @$archive->create($this->tmpDir, PCLZIP_OPT_REMOVE_PATH, $this->tmpDir);
    }

    /**
     * Metoda "usuwa" z znaczniki, które nie zostały zastąpionwe danymi
     * @param string $content
     * @return string
     */
    private function clearUndefinedFields($content) {
        return preg_replace('/\\' . $this->delimiter[0] . $this->cleanRegExp . '\s*\w*\s*' . $this->cleanRegExp . '\\' . $this->delimiter[1] . '/is', $this->debugMode == TRUE ? '[undefined field: \1]' : '<!-- undefined_field_\1 -->', $content);
    }

    /**
     * Kompaktowa metoda czyszcząca wskazany element
     * @param string $content
     * @return string
     */
    private function cleanAndClear($content) {
        $content = str_ireplace('<w:lastRenderedPageBreak/>', '', $content); // faster
        //cleanTag
        $nbr_del = 0;
        foreach (array('<w:proofErr', '<w:noProof', '<w:lang', '<w:lastRenderedPageBreak') as $tag) {
            $p = 0;
            while (($p = $this->foundTag($content, $tag, $p)) !== false) {
                // get the end of the tag
                $pe = strpos($content, '>', $p);
                if ($pe === false) {
                    break; // error in the XML formating
                }
                // delete the tag
                $content = substr_replace($content, '', $p, $pe - $p + 1);
            }
        }
        //cleanRsID
        /* From TBS script
         * Delete XML attributes relative to log of user modifications. Returns the number of deleted attributes.
          In order to insert such information, MsWord do split TBS tags with XML elements.
          After such attributes are deleted, we can concatenate duplicated XML elements. */
        $rs_lst = array('w:rsidR', 'w:rsidRPr');
        $nbr_del = 0;
        foreach ($rs_lst as $rs) {
            $rs_att = ' ' . $rs . '="';
            $rs_len = strlen($rs_att);
            $p = 0;
            while ($p !== false) {
                // search the attribute
                $ok = false;
                $p = strpos($content, $rs_att, $p);
                if ($p !== false) {
                    // attribute found, now seach tag bounds
                    $po = strpos($content, '<', $p);
                    $pc = strpos($content, '>', $p);
                    if (($pc !== false) && ($po !== false) && ($pc < $po)) { // means that the attribute is actually inside a tag
                        $p2 = strpos($content, '"', $p + $rs_len); // position of the delimiter that closes the attribute's value
                        if (($p2 !== false) && ($p2 < $pc)) {
                            // delete the attribute
                            $content = substr_replace($content, '', $p, $p2 - $p + 1);
                            $ok = true;
                            $nbr_del++;
                        }
                    }
                    if (!$ok)
                        $p = $p + $rs_len;
                }
            }
        }
        // delete empty tags
        $content = str_ireplace(array('<w:rPr></w:rPr>', '<w:pPr></w:pPr>'), '', $content);
        //cleanDuplicatedLayout
        $wro = '<w:r';
        $wro_len = strlen($wro);
        $wrc = '</w:r';
        $wrc_len = strlen($wrc);
        $wto = '<w:t';
        $wto_len = strlen($wto);
        $wtc = '</w:t';
        $wtc_len = strlen($wtc);
        $nbr = 0;
        $wro_p = 0;
        while (($wro_p = $this->foundTag($content, $wro, $wro_p)) !== false) {
            $wto_p = $this->foundTag($content, $wto, $wro_p);
            if ($wto_p === false) {
                break; // error in the structure of the <w:r> element
            }
            $first = true;
            do {
                $ok = false;
                $wtc_p = $this->foundTag($content, $wtc, $wto_p);
                if ($wtc_p === false) {
                    break; // error in the structure of the <w:r> element
                }
                $wrc_p = $this->foundTag($content, $wrc, $wro_p);
                if ($wrc_p === false) {
                    break; // error in the structure of the <w:r> element
                }
                if (($wto_p < $wrc_p) && ($wtc_p < $wrc_p)) { // if the found <w:t> is actually included in the <w:r> element
                    if ($first) {
                        $superflous = '</w:t></w:r>' . substr($content, $wro_p, ($wto_p + $wto_len) - $wro_p); // should be like: '</w:t></w:r><w:r>....<w:t'
                        $superflous_len = strlen($superflous);
                        $first = false;
                    }
                    $x = substr($content, $wtc_p + $superflous_len, 1);
                    if ((substr($content, $wtc_p, $superflous_len) === $superflous) && (($x === ' ') || ($x === '>'))) {
                        // if the <w:r> layout is the same same the next <w:r>, then we join it
                        $p_end = strpos($content, '>', $wtc_p + $superflous_len); //
                        if ($p_end === false) {
                            break; // error in the structure of the <w:t> tag
                        }
                        $content = substr_replace($content, '', $wtc_p, $p_end - $wtc_p + 1);
                        $nbr++;
                        $ok = true;
                    }
                }
            } while ($ok);
            $wro_p = $wro_p + $wro_len;
        }
        return $content;
    }

    /**
     * Metoda filtrująca dane przed wstawieniem do wydruku
     * @param mixed $value
     * @return mixed
     */
    private function filter($value) {
        return htmlspecialchars(html_entity_decode($value, ENT_COMPAT, 'UTF-8'), ENT_QUOTES, 'UTF-8');
    }

    /**
     * Found the next tag of the asked type. (Not specific to MsWord, works for any XML)
     * @param string $txt
     * @param string $Tag
     * @param int $PosBeg
     * @return boolean
     */
    private function foundTag($txt, $Tag, $PosBeg) {
        $len = strlen($Tag);
        $p = $PosBeg;
        while ($p !== false) {
            $p = strpos($txt, $Tag, $p);
            if ($p === false)
                return false;
            $x = substr($txt, $p + $len, 1);
            if (($x === ' ') || ($x === '/') || ($x === '>')) {
                return $p;
            } else {
                $p = $p + $len;
            }
        }
        return false;
    }

    /**
     * Metoda znajduje numer pozycji najbliższego elementu znajdującego się "przed" wskazanym elementem.
     * Służy do znajdowania obszaru obejmującego element np. <w:p...element...</w:p> lub <w:t>...element...</w:t>
     * @param string $start_string element względem którego odbywa się wyszukiwanie
     * @param string $needle szukany element
     * @param string $txt ciąg znaków do przeszukania
     * @return int
     */
    private function getNextPosOf($start_string, $needle, $txt) {
        $current_pos = stripos($txt, $start_string);
        $len = strlen($needle);
        $not_found = true;
        while ($not_found && $current_pos <= strlen($txt)) {
            if (substr($txt, $current_pos, $len) == $needle) {
                return $current_pos;
            } else {
                $current_pos = $current_pos + 1;
            }
        }
        return 0;
    }

    /**
     * Metoda znajduje numer pozycji najbliższego elementu znajdującego się "za" wskazanym elementem.
     * Służy do znajdowania obszaru obejmującego element np. <w:p...element...</w:p> lub <w:t>...element...</w:t>
     * @param type $start_string
     * @param type $needle
     * @param type $txt
     * @return int
     */
    private function getPreviousPosOf($start_string, $needle, $txt) {
        $current_pos = stripos($txt, $start_string);
        $len = strlen($needle);
        $not_found = true;
        while ($not_found && $current_pos >= 0) {
            if (substr($txt, $current_pos, $len) == $needle) {
                return $current_pos;
            } else {
                $current_pos = $current_pos - 1;
            }
        }
        return 0;
    }

    /**
     * Metoda znajduje listę plików, których nazwy są zgodne z wartością argumentu
     * @staticvar array $files
     * @param string $file_name
     * @return array
     */
    private function getFilesStartingWith($file_name) {
        $dir = $this->tmpDir . "/word/";
        static $files;
        if (!isset($files)) {
            $files = scandir($dir);
        }
        $found_files = array();
        foreach ($files as $file) {
            if (is_file($dir . $file)) {
                if (strpos($file, $file_name) !== FALSE) {
                    $found_files[] = $file;
                }
            }
        }
        return $found_files;
    }

    /**
     * Metoda usuwa katalog tymczasowy, w kórym został rozpakowany szablon oraz wygenerowany dokument.
     * Metoda uruchamiana automatycznie jako shutdown_function - patrz konstruktor klasy
     * @param string $target ścieżka do aktualnie usuwanego elementu
     * @return boolean wynik usunięcia katalogu
     */
    public function cleanTemp($target) {
        if (is_dir($target) == FALSE || is_link($target)) {
            return unlink($target);
        }
        foreach (scandir($target) as $file) {
            if ($file == '.' || $file == '..')
                continue;
            if ($this->cleanTemp($target . DIRECTORY_SEPARATOR . $file) == FALSE) {
                chmod($target . DIRECTORY_SEPARATOR . $file, 0777);
                if ($this->cleanTemp($target . DIRECTORY_SEPARATOR . $file) == FALSE)
                    return false;
            };
        }
        return rmdir($target);
    }

}
