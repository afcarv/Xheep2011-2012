import java.util.Calendar;

public class Contacto {
	public String nome;
	public Calendar aniversario;
	public String sexo;
	public String profiss�o;
	public String telefone;
	public String email;
	
	Contacto(String _nome, Calendar _aniversario, String _sexo, String _profiss�o, String _telefone, String _email)
	{
		nome = _nome;
		aniversario = _aniversario;
		sexo = _sexo;
		profiss�o = _profiss�o;
		telefone = _telefone;
		email = _email;
	}
	
	public int idade()
	{
		// http://www.exampledepot.com/egs/java.util/GetAge.html
		Calendar today = Calendar.getInstance();
		Calendar bday = (Calendar)aniversario.clone();
		
		int age = today.get(Calendar.YEAR) - aniversario.get(Calendar.YEAR);
		bday.add(Calendar.YEAR, age);
		if (today.before(bday)) age--;
		
		return age;
	}
	
	public String toString()
	{
		return nome + ", " + idade() + " anos de idade, do sexo "
			+ sexo + ", " + profiss�o + ", telefone n.� " + telefone
			+ ", e-mail: " + email;
	}
}
