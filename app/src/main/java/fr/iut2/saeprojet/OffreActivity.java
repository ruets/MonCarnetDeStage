package fr.iut2.saeprojet;

import androidx.appcompat.app.AppCompatActivity;

import android.os.Bundle;
import android.text.Html;
import android.text.method.LinkMovementMethod;
import android.widget.TextView;

public class OffreActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_offre);

        TextView textView = findViewById(R.id.offre_details);
        String linkText = "Cliquez ici pour ouvrir Google.";
        String link = "https://www.google.com";
        textView.setText(Html.fromHtml("<a href=\"" + link + "\">" + linkText + "</a>"));
        textView.setMovementMethod(LinkMovementMethod.getInstance());
    }
}