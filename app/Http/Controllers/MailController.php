<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Mail\DemoMail;
use App\Mail\SurveyMail;

class MailController extends Controller
{
    public function index()
    {
        return view('emails.SurveyMail');
        $mailData = [
            'title' => 'Mail from ItSolutionStuff.com',
            'body' => 'This is for testing email using smtp.'
        ];

        Mail::to('bell.aragonz@gmail.com')->send(new DemoMail($mailData));

        dd("Email is sent successfully.");
    }

    public function survey(Request $request)
    {
        $to = $request->to ?? 'apirak@hafele.co.th';

        $mailData = [
            'customerName' => $request->customerName ?? '',
            'customerMobile' => $request->customerMobile ?? '',
            'customerAddress' => $request->customerAddress ?? '',
            'customerInformation' => $request->customerInformation ?? '',

            'salesPersonID' => $request->salesPersonID ?? '',
            'salesPersonName' => $request->salesPersonName ?? '',
            'salesPersonLocation' => $request->salesPersonLocation ?? '',

            'lockModel' => $request->lockModel ?? '',
            'installationLocation' => $request->installationLocation ?? '',
            'installationLocationMessage' => $request->installationLocationMessage ?? '',
            'doorCondition' => $request->doorCondition ?? '',
            'doorConditionMessage' => $request->doorConditionMessage ?? '',
            'existingDoorRetrofit' => $request->existingDoorRetrofit ?? '',
            'existingDoorRetrofitMessage' => $request->existingDoorRetrofitMessage ?? '',
            'existingDoorRetrofitCaution' => $request->existingDoorRetrofitCaution ?? '',
            'doorType' => $request->doorType ?? '',
            'doorTypeMessage' => $request->doorTypeMessage ?? '',
            'swingDoorType' => $request->swingDoorType ?? '',
            'swingDoorTypeMessage' => $request->swingDoorTypeMessage ?? '',
            'swingDoorJamb' => $request->swingDoorJamb ?? '',
            'swingDoorJambMessage' => $request->swingDoorJambMessage ?? '',
            'swingDoorJambCaution' => $request->swingDoorJambCaution ?? '',

            'doorThickness' => $request->doorThickness ?? '',
            'doorThicknessInput' => $request->doorThicknessInput ?? '',
            'doorThicknessInputMessage' => $request->doorThicknessInputMessage ?? '',
            'doorThicknessMessage' => $request->doorThicknessMessage ?? '',

            'doorMaterial' => $request->doorMaterial ?? '',
            'doorMaterialMessage' => $request->doorMaterialMessage ?? '',
            'doorLeaf' => $request->doorLeaf ?? '',
            'doorLeafMessage' => $request->doorLeafMessage ?? '',
        ];

        Mail::to($to)->send(new SurveyMail($mailData));

        return response()->json([
          'status' => true,
          'message' => 'Email is sent successfully.'
        ]);
    }
}
