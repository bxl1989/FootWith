import org.json.JSONException;
import org.junit.Test;
import edu.thu.cslab.footwith.server.JSONHelper;

import java.util.Vector;

/**
 * Created with IntelliJ IDEA.
 * User: roselone
 * Date: 3/16/13
 * Time: 1:44 AM
 * To change this template use File | Settings | File Templates.
 */
public class JSONHelperTest {
    private JSONHelper jsonHelper=new JSONHelper();
    @Test
    public void convertToStringTest(){
        int[] tmp={123,2143,213};
        System.out.println(jsonHelper.convertToString(tmp));
    }
    @Test
    public void convertToArrayTest() throws JSONException {
        String tmp="[123,2143,213]";
        Vector<Integer> result=jsonHelper.convertToArray(tmp);
        for (int i=0;i<result.size();i++)
            System.out.println(result.get(i));
    }
}