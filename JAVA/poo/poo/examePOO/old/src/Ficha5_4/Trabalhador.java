package Ficha5_4;
public class Trabalhador extends Jogador
{
	//número interno da empresa:
	public int workid;
	
	//número de apostas possíveis:
	protected void init()
	{
		super.init();
		betLimit = 5;
	}
	//contrutor,q herda nome e idade da classe jogador e tem ainda workid
	Trabalhador(String _name, int _age, int _telephone, int _workid)
	{
		super(_name, _age, _telephone);
		workid = _workid;
	}
	
	//construtor com limite de apostas:
	Trabalhador(int num)
	{
		super();
		betLimit = 5;
		
		workid = num;	
	}
	
	boolean equals(Trabalhador j)
	{
		return super.equals(j) && (workid == j.workid);
	}
}
