<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\InterestCalculationRequest;
use App\Http\Resources\InterestCalculationResource;
use App\Interfaces\Repository\InterestCalculationRepositoryInterface;
use App\Interfaces\Repository\InterestRateRepositoryInterface;
use App\Interfaces\Service\API\InterestServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class InterestController extends Controller
{
    public function __construct(
        private readonly InterestServiceInterface $interestService,
        private readonly InterestCalculationRepositoryInterface $interestCalculationRepository,
        private readonly InterestRateRepositoryInterface $interestRateRepository
    ) {}

    /**
     * @OA\Get(
     *     path="/api/interest",
     *     summary="Get all interest calculations",
     *     tags={"Interest"},
     *     @OA\Response(
     *         response=200,
     *         description="Get all interest calculations",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="start_date", type="string", format="date", example="2021-01-01"),
     *             @OA\Property(property="end_date", type="string", format="date", example="2021-12-31"),
     *             @OA\Property(property="calculated_interest", type="number", format="float", example="0.05"),
     *             @OA\Property(property="principal_amount", type="number", format="int", example="1000"),
     *             @OA\Property(property="days_Count", type="number", format="int", example="10"),
     *          )
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        return response()->json(
            InterestCalculationResource::collection(
                $this->interestCalculationRepository->all()
            )
        );
    }

    /**
     * @OA\Post(
     *     path="/api/interest/calculate",
     *     summary="Calculate interest",
     *     tags={"Interest"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"start_date", "end_date", "amount"},
     *             @OA\Property(property="start_date", type="string", format="date", example="2024-01-01"),
     *             @OA\Property(property="end_date", type="string", format="date", example="2024-01-30"),
     *             @OA\Property(property="amount", type="number", format="float", example=100000),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Calculate interest",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="start_date", type="string", format="date", example="2024-01-01"),
     *             @OA\Property(property="end_date", type="string", format="date", example="2024-01-30"),
     *             @OA\Property(property="calculated_interest", type="number", format="float", example=10),
     *             @OA\Property(property="principal_amount", type="number", format="int", example=100000),
     *             @OA\Property(property="days_Count", type="number", format="int", example=10),
     *         )
     *     )
     * )
     */
    public function calculate(InterestCalculationRequest $request): JsonResponse
    {
        try {
            $interestCalculation = $this->interestService->calculate($request->validated());

            return response()->json(
                new InterestCalculationResource($interestCalculation),
                Response::HTTP_CREATED
            );
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json([], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/interest/get-min-max-dates",
     *     summary="Get min and max dates",
     *     tags={"Interest"},
     *     @OA\Response(
     *         response=200,
     *         description="Get min and max dates for the frontend to the interest calculator",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="min", type="string", format="date", example="2021-01-01"),
     *             @OA\Property(property="max", type="string", format="date", example="2021-12-31")
     *         )
     *     )
     * )
     */
    public function getMinAndMaxDates(): JsonResponse
    {
        return response()->json([
            'min' => $this->interestRateRepository->getMinInterestEffectiveDate(),
            'max' => $this->interestRateRepository->getMaxInterestEffectiveDate()
        ]);
    }
}
