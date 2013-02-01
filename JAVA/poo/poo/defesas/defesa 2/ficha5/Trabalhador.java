public class Trabalhador extends Jogador
{
	public int workid;
	
	protected void init()
	{
		super.init();
		betLimit = 5;
	}
	
	Trabalhador(String _name, int _age, int _telephone, int _workid)
	{
		super(_name, _age, _telephone);
		workid = _workid;
	}

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
