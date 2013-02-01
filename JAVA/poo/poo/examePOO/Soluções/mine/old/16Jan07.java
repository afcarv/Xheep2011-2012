
public class Atleta {
	private static final int N_ouro = 0;
	private static final int N_prata = 0;
	private static final int N_bronze = 0;
	private static Object nome;
	private static Object tipo;

	//Exercício 2:
	public static void main(String[]args)
	{	
		Equipa e = new Equipa();
		int max = e.MAX_ATLETAS;

		try
		{
			File f1 = new File("mostraMedalhas.txt");
			BufferedWriter bout;
			bout= new BufferedWriter((Writer) FileWriter(f1));
			String ponha = "";

			Atleta a[]=new Atleta[max];

			for(int i=0;i<a.length;i++){
				if(a[i].N_ouro >=1||a[i].N_prata >=1||a[i].N_bronze >=1){
					ponha = a[i].nome.toString()+a[i].tipo.toString()+a[i].N_ouro+a[i].N_bronze+a[i].N_prata;
					bout.write(ponha);
				}
			}
			bout.flush();
			bout.close();
		}
		catch(IOException e1)
		{
			System.out.println("Erro");
		}
	}
	private static Object FileWriter(File f1) {
		// TODO Auto-generated method stub
		return null;
	}
	//Exercício 3:
	private int tmin;
	public void SeleccionaEquipa() throws CloneNotSupportedException
	{

		Equipa e = new Equipa();
		int max = e.MAX_ATLETAS;
		Atleta corr[]=new Atleta[max];
		Atleta salt[]=new Atleta[max];
		Atleta sel[]=new Atleta[5];

		//variáveis para determinar recordes:
		int cem =0 ;
		int quat =0 ;
		int oitoc =0 ;
		int comp =0 ;
		int alt = 0;
		//variáveis para determinar índices:
		int cemi =0 ;
		int quati =0 ;
		int oitoci =0 ;
		int compi =0 ;
		int alti = 0;

		for(int i=0;i<corr.length;i++)
		{
			if(corr[i].tipo.equals("100")&& corr[i].tmin<cem)
			{
				cem=corr[i].tmin;
				cemi=i;
				sel[0]=(Atleta) corr[i].nome;
			}
			else if(corr[i].tipo.equals("400")&& corr[i].tmin<quat)
			{
				quat=corr[i].tmin;
				quati=i;
				sel[1]=(Atleta) corr[i].nome;
			}
			else if(corr[i].tipo.equals("800")&& corr[i].tmin<oitoc)
			{
				oitoc=corr[i].tmin;
				oitoci=i;
				sel[2]=(Atleta) corr[i].nome;
			}
		}
		for(int i =0;i<salt.length;i++)
		{
			if(salt[i].tipo.equals("100")&& salt[i].tmin<cem)
			{
				compi=salt[i].tmin;
				compi=i;
				sel[3]=(Atleta) salt[i].nome;
			}
			if(salt[i].tipo.equals("100")&& salt[i].tmin<cem)
			{
				alti=salt[i].tmin;
				alti=i;
				sel[4]=(Atleta) salt[i].nome;
			}
		}
	}
}





