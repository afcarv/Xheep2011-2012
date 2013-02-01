import java.sql.Date;
import java.util.ArrayList;

class Requisicao {

	Date data;
	private double cota;
	private ArrayList<Livro> req;
	
	//constructor
	public Requisicao(double cota, Date data){
		this.cota=cota;
		this.data=data;
	}
	
	public Requisicao(){
		req = new ArrayList<Livro>();
	}
	
	public Requisicao(ArrayList<Livro> req){
		this.req = req;
	}
	public void addLivro(Livro a) {
		req.add(a);
	}
	//estes 3 constructores acima foram para criar um objecto na main do tipo requisiçao capaz de guardar objectos do tipo livro
	
	public Date get_data(){
		return data;
	}
	//metodo que procura em requisicoes a cota, se for igual retorna true
	public boolean req_verify(double cota){
		for (Livro e:req)
			if (e.getCota()==(cota)){
				return true;
			}
			return false;
	}
	
	//metodo para verificaçao do prazo
	public int passouPrazo(Date dataInicial, Date dataFinal) {  
		long milisecInicial = dataInicial.getTime();  
		long milisecFinal = dataFinal.getTime();
		return (int) ((milisecFinal - milisecInicial) * 1000 / 86.400);//*1000 para converter em segundos e /86.400 porque é a duraçao de um dia
		}
}
