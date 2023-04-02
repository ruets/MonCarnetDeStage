package fr.iut2.saeprojet.ui.offres;

import android.content.Context;
import android.content.Intent;
import android.media.Image;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.ScrollView;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.fragment.app.Fragment;

import java.util.ArrayList;

import fr.iut2.saeprojet.MainActivity;
import fr.iut2.saeprojet.OffreActivity;
import fr.iut2.saeprojet.R;
import fr.iut2.saeprojet.api.APIClient;
import fr.iut2.saeprojet.api.ResultatAppel;
import fr.iut2.saeprojet.databinding.FragmentOffresBinding;
import fr.iut2.saeprojet.entity.CompteEtudiant;
import fr.iut2.saeprojet.entity.Entreprise;
import fr.iut2.saeprojet.entity.EntreprisesResponse;
import fr.iut2.saeprojet.entity.Offre;
import fr.iut2.saeprojet.entity.OffresResponse;

public class OffresFragment extends Fragment {

    private FragmentOffresBinding binding;

    private LinearLayout offres, offresList;
    private ScrollView offresScroll;
    private TextView offresSearchText;
    private ImageView offresSearchIcon;

    public View onCreateView(@NonNull LayoutInflater inflater,
                             ViewGroup container, Bundle savedInstanceState) {

        binding = FragmentOffresBinding.inflate(inflater, container, false);
        View root = binding.getRoot();

        init();

        return root;
    }

    @Override
    public void onDestroyView() {
        super.onDestroyView();
        binding = null;
    }

    private void init() {
        MainActivity mainActivity = (MainActivity) getActivity();

        offresList = binding.offresList;
        offresSearchText = binding.offresSearchText;
        offresSearchIcon = binding.offresSearchIcon;

        APIClient.getOffres(mainActivity, new ResultatAppel<OffresResponse>() {
            @Override
            public void traiterResultat(OffresResponse response) {
                ArrayList<LinearLayout> offresViewsRetenues = new ArrayList<>();
                ArrayList<LinearLayout> offresViews = new ArrayList<>();
                ArrayList<LinearLayout> offresViewsConsultees = new ArrayList<>();
                for (Offre offre : response.offres) {

                    LinearLayout offreView = new LinearLayout(mainActivity);
                    offreView.setOrientation(LinearLayout.HORIZONTAL);
                    offreView.setBackground(getResources().getDrawable(R.drawable.border));

                    TextView offreViewTitle = new TextView(mainActivity);
                    offreViewTitle.setText(offre.intitule);
                    offreViewTitle.setLayoutParams(new LinearLayout.LayoutParams(0, LinearLayout.LayoutParams.WRAP_CONTENT, 1));
                    offreViewTitle.setLines(2);

                    String status = "Non consultée";
                    ImageView offreViewIcon = new ImageView(mainActivity);
                    for (String offreConsultee : offre.offreConsultees) {
                        if (mainActivity.getEtudiant().offreConsultees.contains(offreConsultee)) {
                            offreViewIcon.setImageDrawable(getResources().getDrawable(R.drawable.eye_icon));
                            status = "Consultée";
                        }
                    }

                    for (String offreRetenue : offre.offreRetenues) {
                        if (mainActivity.getEtudiant().offreRetenues.contains(offreRetenue)) {
                            offreViewIcon.setImageDrawable(getResources().getDrawable(R.drawable.star_filled));
                            status = "Retenue";
                        }
                    }

                    offreView.addView(offreViewTitle);
                    offreView.addView(offreViewIcon);

                    offreView.setOnClickListener(new View.OnClickListener() {
                        @Override
                        public void onClick(View v) {
                            Intent intent = new Intent(mainActivity, OffreActivity.class);
                            intent.putExtra(OffreActivity.OFFRE_KEY, offre);
                            intent.putExtra(OffreActivity.ETUDIANT_KEY, mainActivity.getEtudiant());
                            startActivity(intent);
                        }
                    });

                    if (status.equals("Consultée")) {
                        offresViewsConsultees.add(offreView);
                    } else if (status.equals("Retenue")) {
                        offresViewsRetenues.add(offreView);
                    } else {
                        offresViews.add(offreView);
                    }
                }

                for (LinearLayout offreView : offresViewsRetenues) {
                    offresList.addView(offreView);
                }

                for (LinearLayout offreView : offresViews) {
                    offresList.addView(offreView);
                }

                for (LinearLayout offreView : offresViewsConsultees) {
                    offresList.addView(offreView);
                }

                TextView offreViewTitle = new TextView(mainActivity);
                offreViewTitle.setText("Fin des offres");
                offreViewTitle.setBackground(getResources().getDrawable(R.drawable.border));
                offreViewTitle.setLayoutParams(new LinearLayout.LayoutParams(0, LinearLayout.LayoutParams.WRAP_CONTENT, 1));
                offresList.addView(offreViewTitle);
            }

            @Override
            public void traiterErreur() {
                // TODO: handle error
            }

        });
    }
}