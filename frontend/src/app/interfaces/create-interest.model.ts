export interface CreateInterest {
    start_date: string;
    end_date: string;
    principal_amount: number;
}

export function formatCreateInterest(params: CreateInterest): CreateInterest {
    return {
        ...params,
        start_date: new Date(params.start_date).toLocaleDateString('sv-SE'),
        end_date: new Date(params.end_date).toLocaleDateString('sv-SE'),
    } as CreateInterest;
}
