package com.startuppuccino.accounts;

import javax.servlet.http.HttpServletResponse;
import javax.validation.Valid;

import java.io.IOException;
import java.security.Principal;
import java.time.Instant;
import java.util.Arrays;
import java.util.Date;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.MediaType;
import org.springframework.security.access.prepost.PreAuthorize;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.validation.BindingResult;
import org.springframework.validation.Validator;
import org.springframework.web.bind.WebDataBinder;
import org.springframework.web.bind.annotation.InitBinder;
import org.springframework.web.bind.annotation.ModelAttribute;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.bind.annotation.ResponseBody;
import org.springframework.web.multipart.MultipartFile;



@Controller
public class AccountController
{
    @Autowired
    private AccountRepository accountRepository;

    @Autowired
    private AccountService accountService;


    @RequestMapping(value = "/login", method = RequestMethod.GET)
    public String login()
    {
        return "accounts/login";
    }


    @RequestMapping(value = "/registration", method = RequestMethod.GET)
    public String registration(Model model)
    {
        model.addAttribute(new Account());
        return "accounts/registration";
    }


    @RequestMapping(value = "/registration", method = RequestMethod.POST)
    public String registration(@Valid @ModelAttribute Account account,
                               BindingResult bindingResult,
                               @RequestParam MultipartFile avatar) throws IOException
    {
        account.setCreated(Instant.now());

        if (account.getRole() != Account.Role.ROLE_USER && account.getRole() != Account.Role.ROLE_MENTOR)
            account.setRole(Account.Role.ROLE_USER);

        if (!avatar.isEmpty())
            account.setAvatar(avatar.getBytes());

        if (bindingResult.hasErrors())
        {
            account.setPassword(null);
            return "accounts/registration";
        }

        accountService.save(account);

        accountService.login(account);

        return "redirect:/";
    }


    @RequestMapping(value = "/account", method = RequestMethod.GET)
    @PreAuthorize("isAuthenticated()")
    public String account(Model model, Principal principal)
    {
        Account account = accountService.getCurrentAccount(principal);
        if (account.isHasAvatar())
            account.setAvatar(new byte[1]);
        account.setPassword("hidden");
        model.addAttribute(account);
        return "accounts/account";
    }


    @Autowired
    private Validator validator;


    @InitBinder
    public void initBinder(WebDataBinder binder)
    {
        binder.setDisallowedFields("avatar");
    }

    @RequestMapping(value = "/account", method = RequestMethod.POST)
    @PreAuthorize("isAuthenticated()")
    public String account(@ModelAttribute Account account,
                          BindingResult bindingResult,
                          @RequestParam MultipartFile avatar,
                          Principal principal,
                          Model model) throws IOException
    {
        if (account.getRole() != Account.Role.ROLE_USER && account.getRole() != Account.Role.ROLE_MENTOR)
            account.setRole(Account.Role.ROLE_USER);





        // Updating only specific fields of actual account
        Account currentAccount = accountService.getCurrentAccount(principal);
        currentAccount.setFirstName (account.getFirstName ());
        currentAccount.setLastName  (account.getLastName  ());
        currentAccount.setRole      (account.getRole      ());
        currentAccount.setBackground(account.getBackground());
        currentAccount.setAbout     (account.getAbout     ());

        if (!avatar.isEmpty())
        {
            currentAccount.setAvatar(avatar.getBytes());
        }

        validator.validate(currentAccount, bindingResult);

        account.setAvatar(currentAccount.getAvatar()); // Needed to show avatar picture
        account.setId(currentAccount.getId()); // Needed to show avatar picture
        account.setEmail(currentAccount.getEmail()); // Needed to show page title

        System.out.println(Arrays.toString(bindingResult.getAllErrors().toArray()));

        if (!bindingResult.hasErrors())
        {
            accountRepository.save(currentAccount);

            model.addAttribute("showSavedSuccessfullyMessage", "true");
        }
        return "accounts/account";
    }




    @RequestMapping(value = "/people", method = RequestMethod.GET)
    public String people(Model model)
    {
        model.addAttribute("accounts", accountRepository.findAll());
        return "accounts/people";
    }

    @RequestMapping(value = "/people/{id}", method = RequestMethod.GET)
    public String people(@PathVariable("id") Integer id, Model model)
    {
        model.addAttribute(accountRepository.findOne(id));
        return "accounts/person";
    }


    @ResponseBody
    @RequestMapping(value = "/people/{id}/avatar", method = RequestMethod.GET, produces = MediaType.IMAGE_JPEG_VALUE)
    public byte[] avatar(@PathVariable("id") Integer id, HttpServletResponse response)
    {
        response.setHeader("Cache-Control", "max-age: 300");
        response.setHeader("Pragma", "cache");
        response.setDateHeader("Expires", new Date().getTime() + 300 * 1000);

        Account account = accountRepository.findOne(id);
        if (account != null)
            return account.getAvatar();
        else
            return null;
    }



}
