<?php

namespace App\Services;

use App\Helpers\StringHelper;
use Illuminate\Http\Request;
use App\Models\Subscriber;

class UploadRecordsService
{

    /**
     * Get filetype from request and distribute to proper upload method
     */
    public function handle(Request $request)
    {
        $fileName = $request->filename;
        
        // \Log::info($request);
        if (!file_exists($fileName) || !is_readable($fileName))
        {
            return response()->json(['error' => 'Could not read or open provided file']);
        }

        \Log::info($fileName);
        return self::uploadCsv($fileName);
    }


    public static function uploadCsv(string $filename)
    {
        try {

            $header = null;
            $numempty = 0;
            $numduplicate = 0;
            $data = [];
            $numSkipped = 0;
            $clean_headers = [];
            $current_row_number = 0; // Pass column header row
            $allowedcolheaders = UploadRecordsService::headersCsvUpload();

            if (($filehandler = fopen($filename, 'r')) !== false )
            {
                $current_row_number++;
                while (($row = fgetcsv($filehandler, 1000, ',')) !== false) 
                {
                    if ($current_row_number == 1)
                    {
                        // $current_row_number++;
                        $header = StringHelper::stripNonAscii($row);
                        foreach ($header as $col_idx => $col_title)
                        {
                            $clean_title = strtolower(trim($col_title));
                            \Log::info("Clean title: ".$clean_title." Curr row num: ".$current_row_number);
                            if ($clean_title === '')
                            {
                                $clean_headers[] = '';
                            }
                            else 
                            {
                                // Handle duplicate entries
                                // \Log::info($allowedcolheaders);
                                $fuzzymatchheader = $allowedcolheaders[$clean_title];
                                $clean_headers[] = $fuzzymatchheader;
                            }
                        }
                    }
                    elseif (implode($row) === '')
                    {
                        // Handles empty row
                        $numempty++;
                    }
                    else
                    {
                        $line = join(',',$row);
                        if (!isset($data[$line]))
                        {
                            $colcntrow = count($row); 
                            // \Log::info($clean_headers);
                            $data[$line] = array_combine($clean_headers, $row);
                        }
                        else
                        {
                            $numduplicate++;
                        }
                    }
                    $current_row_number++;
                }
                fclose($filehandler);
                if ($filehandler === null)
                {
                    return response()->json(['error' => 'File provided was empty']);
                }
            }
            else
            {
                return response()->json(['error' => 'Unable to read file']);
            }

            $entries = [];
            foreach ($data as $str_line => $entry)
            {
                // $fname = $entry[]
                // \Log::info($entry["First Name"]);
                $fname = $entry["First Name"];
                $lname = $entry["Last Name"];
                $date = $entry["Date (YYYY-MM-DD)"];
                $phoneNo = $entry["Phone No."];
                $businessId = auth()->user()->businessId;

                if (strlen($phoneNo) === 10) {
                    $phoneNo = "+1".$phoneNo;
                } else {
                    $numSkipped++;
                    continue;
                }

                $insertData = [
                    'firstName' => $fname,
                    'lastName' => $lname,
                    'visitDate'  => $date,
                    'phoneNumber' => $phoneNo,
                    'businessId' => $businessId,
                    'lastMsgSentType' => 'Uncontacted'
                ];

                $subscriber = Subscriber::firstOrCreate($insertData);
                \Log::info($subscriber);
            }

        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public static function headersCsvUpload()
    {
        return [
            'date' => 'Date (YYYY-MM-DD)',
            'phone no' => 'Phone No.',
            'first name' => 'First Name',
            'last name' => 'Last Name'
        ];
    }
}